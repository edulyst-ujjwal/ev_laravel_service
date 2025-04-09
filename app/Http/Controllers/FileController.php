<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use config;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class FileController extends Controller
{
   public function index(Request $request)
    {
        $validated = $request->validate([
            'limit' => 'sometimes|integer|min:1|max:100',
            'order_by' => 'sometimes|in:title,created_at',
            'order_direction' => 'sometimes|in:asc,desc'
        ]);

        $limit = $validated['limit'] ?? 10;
        $orderBy = $validated['order_by'] ?? 'created_at';
        $orderDirection = $validated['order_direction'] ?? 'desc';

        $files = File::orderBy($orderBy, $orderDirection)
                     ->paginate($limit)
                     ->appends($request->query());

        return view('files.index', compact('files'));
    }




    public function create()
    {   

        return view('files.create');
    }

    public function generateQr()
    {   

        return view('files.qr_generate');
    }




    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file',
        ]);

        $driver = config('filesystems.default');
        $file = $request->file('file');
        
        $path = Storage::disk($driver)->putFileAs(
            'media',
            $file,
            $file->hashName(),
            [
                'ContentType' => $file->getMimeType(),
                'ContentDisposition' => 'inline'
            ]
        );

        $url = $this->getFileUrl($path, $driver);

        $file = File::create([
            'title' => $request->title,
            'url' => $url,
        ]);

        return redirect()->route('files.index')->with('success', 'File uploaded successfully.');
    }

    private function getFileUrl($path, $driver)
    {   
        // echo $driver;exit;
        if ($driver === 'azure') {
            $storageName = config('filesystems.disks')['azure']['name'];
            $container = config('filesystems.disks')['azure']['container'];
            return "https://$storageName.blob.core.windows.net/$container/$path";
        } elseif ($driver === 's3') {
            $bucket = config('filesystems.disks')['s3']['bucket'];
            $region = config('filesystems.disks')['s3']['region'];
            return "https://$bucket.s3.$region.amazonaws.com/$path";
        }

        return Storage::disk($driver)->url($path);
    }

    public function destroy(File $file)
    {
        $driver = config('filesystems.default');
        Storage::disk($driver)->delete($file->url);

        $file->delete();
        return redirect()->route('files.index')->with('success', 'File deleted successfully.');
    }

    public function uploadViaApi(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $driver = config('filesystems.default');
        $path = $request->file('file')->store('uploads', $driver);
        $url = $this->getFileUrl($path, $driver);
        $file = File::create([
            'title' => $request->title,
            'url' => $url,
        ]);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'file' => $file,
        ], 201);
    }

    public function listFilesViaApi(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $orderBy = $request->input('order_by', 'created_at');
            $orderDirection = $request->input('order_direction', 'desc');
            $files = File::orderBy($orderBy, $orderDirection)
                         ->paginate($limit);

            return response()->json([
                'message' => 'Files retrieved successfully.',
                'data' => $files,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve files.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

   

    public function getqrcode(Request $request)
    {
        // $request->validate([
        //     'url' => 'required|url',
        // ]);

        // try {
            $url = $request->input('url');
            $title = 'QR Code for ' . $url;
            
            // Generate QR code as PNG image in memory
            $qrCodeImage = QrCode::format('png')
                ->size(300)
                ->generate($url);
            
            // Generate a unique filename
            $filename = 'qrcodes/' . uniqid('qr_', true) . '.png';
             $driver = config('filesystems.default');
            
            // Store the QR code image in Azure
            Storage::disk($driver)->put(
                $filename,
                $qrCodeImage,
                [
                    'ContentType' => 'image/png',
                    'ContentDisposition' => 'inline'
                ]
            );
            
            // Get the public URL
            $fileUrl = $this->getFileUrl($filename, $driver);
            
            // Save to database
            $file = File::create([
                'title' => $title,
                'url' => $fileUrl,
            ]);
            
            return response()->json([
                'status' => 1,
                'message' => 'QR code generated successfully',
                'qrcode_url' => $fileUrl,
                // 'file' => $file
            ], 201);
            
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => 0,
        //         'message' => 'Failed to generate QR code',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }


    public function genQrsave(Request $request)
    {   
        $result = $this->getqrcode($request);
        $data = $result->getData(true);

        if ($data['status'] === 1) {
            // Stream the remote file as a download
            $fileUrl = $data['qrcode_url'];
            $fileContents = file_get_contents($fileUrl); // Fetch the file
            return response()->streamDownload(
                function () use ($fileContents) {
                    echo $fileContents;
                },
                'qrcode.png',
                ['Content-Type' => 'image/png']
            );
        }

        return $result;
    }
}