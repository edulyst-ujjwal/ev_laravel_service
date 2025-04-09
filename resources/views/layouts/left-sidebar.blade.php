<!-- left-sidebar.blade.php -->
<div style="position: fixed; left: 0; top: 0; width: 250px; height: 100%; background-color: #2c3e50; padding: 20px; overflow-y: auto; box-shadow: 2px 0 5px rgba(0,0,0,0.2); z-index: 1100;">
    <h2 style="font-size: 1.8em; color: #ecf0f1; margin-bottom: 30px; text-align: center; font-weight: 300; letter-spacing: 1px;">Menu</h2>
    <ul style="list-style: none; padding: 0; margin: 0;">
        <li style="margin-bottom: 10px;">
            <a href="/files" style="display: flex; align-items: center; padding: 12px 15px; background-color: transparent; color: #ecf0f1; text-decoration: none; border-radius: 6px; transition: all 0.3s; font-size: 1.1em;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'; this.style.paddingLeft='20px';" onmouseout="this.style.backgroundColor='transparent'; this.style.paddingLeft='15px';">
                <span style="margin-right: 10px;">📄</span>Upload Files
            </a>
        </li>
        <li style="margin-bottom: 10px;">
            <a href="/get-qr" style="display: flex; align-items: center; padding: 12px 15px; background-color: transparent; color: #ecf0f1; text-decoration: none; border-radius: 6px; transition: all 0.3s; font-size: 1.1em;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'; this.style.paddingLeft='20px';" onmouseout="this.style.backgroundColor='transparent'; this.style.paddingLeft='15px';">
                <span style="margin-right: 10px;">📊</span>Get QrCode
            </a>
        </li>
    </ul>
</div>

<!-- Add this script at the end of the sidebar file -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add a class to body when sidebar is present
        document.body.classList.add('has-sidebar');
    });
</script>

<style>
    /* Add these styles within the sidebar file */
    body.has-sidebar .fixed-header {
        left: 250px;
        width: calc(100% - 250px);
    }

    body.has-sidebar .main-content {
        margin-left: 250px;
    }
</style>