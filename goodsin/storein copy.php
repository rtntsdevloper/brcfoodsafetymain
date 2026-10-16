<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'qr_scanner_db';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($conn->query($sql) === TRUE) {
    // Select database
    $conn->select_db($db_name);
    
    // Create table for batch codes
    $table_sql = "CREATE TABLE IF NOT EXISTS batch_codes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        batch_code VARCHAR(255) NOT NULL,
        raw_qr_data TEXT,
        scan_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ip_address VARCHAR(45),
        user_agent TEXT,
        status ENUM('active', 'inactive', 'processed') DEFAULT 'active'
    )";
    
    if (!$conn->query($table_sql)) {
        die("Error creating table: " . $conn->error);
    }
} else {
    die("Error creating database: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>QR Batch Code Scanner - PHP MySQL</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            padding: 30px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }
        h2 {
            color: #555;
            margin-bottom: 20px;
            font-size: 1.4rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        .input-group {
            margin-bottom: 25px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            font-family: monospace;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin: 5px;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        button:active {
            transform: translateY(0);
        }
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .qr-container {
            margin: 20px 0;
            position: relative;
        }
        #reader {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
        }
        .result-area {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            text-align: left;
            word-break: break-all;
        }
        .status {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .status.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .batch-list {
            max-height: 500px;
            overflow-y: auto;
        }
        .batch-item {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            border-left: 3px solid #667eea;
            transition: all 0.3s;
        }
        .batch-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .batch-code {
            font-weight: bold;
            color: #667eea;
            font-family: monospace;
            font-size: 16px;
        }
        .batch-date {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📱 QR Batch Code Scanner</h1>
            <div class="subtitle">Scan QR code to auto-fill and store batch information</div>

            <div class="input-group">
                <label>📦 Batch Code / Scan Result:</label>
                <input type="text" id="batchInput" placeholder="Batch code will appear here after scanning..." autocomplete="off">
            </div>

            <div class="input-group">
                <label>📝 Additional Notes (Optional):</label>
                <textarea id="notes" rows="3" placeholder="Add any additional information..."></textarea>
            </div>

            <div class="button-group">
                <button id="startScanBtn">🔍 Start QR Scanner</button>
                <button id="stopScanBtn" style="display:none;" class="btn-danger">⏹️ Stop Scanner</button>
                <button id="saveBtn" class="btn-success">💾 Save to Database</button>
                <button id="clearBtn">🗑️ Clear Form</button>
            </div>

            <div class="qr-container">
                <div id="reader"></div>
            </div>

            <div id="resultArea" class="result-area" style="display: none;">
                <div class="result-label">✅ Last Scanned Data:</div>
                <div id="scannedData"></div>
            </div>

            <div id="statusMessage" class="status info">
                💡 Click "Start QR Scanner" and allow camera access
            </div>
        </div>

        <div class="card">
            <h2>📋 Recent Batch Records</h2>
            <div id="batchList" class="batch-list">
                <div class="empty-state">Loading records...</div>
            </div>
            <div class="button-group" style="margin-top: 20px;">
                <button id="refreshBtn">🔄 Refresh List</button>
                <button id="exportBtn" class="btn-success">📥 Export to CSV</button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // DOM elements
        const batchInput = document.getElementById('batchInput');
        const notes = document.getElementById('notes');
        const startBtn = document.getElementById('startScanBtn');
        const stopBtn = document.getElementById('stopScanBtn');
        const saveBtn = document.getElementById('saveBtn');
        const clearBtn = document.getElementById('clearBtn');
        const refreshBtn = document.getElementById('refreshBtn');
        const exportBtn = document.getElementById('exportBtn');
        const resultArea = document.getElementById('resultArea');
        const scannedDataSpan = document.getElementById('scannedData');
        const statusDiv = document.getElementById('statusMessage');
        const readerDiv = document.getElementById('reader');
        const batchList = document.getElementById('batchList');

        let html5QrCode = null;
        let isScanning = false;
        let currentScannedData = '';

        // Helper function to show status messages
        function showStatus(message, type = 'info') {
            statusDiv.textContent = message;
            statusDiv.className = `status ${type}`;
            
            setTimeout(() => {
                if (statusDiv.className.includes(type) && !isScanning) {
                    statusDiv.className = 'status info';
                    statusDiv.textContent = '✅ Ready for next scan';
                }
            }, 3000);
        }

        // Function to update input field with scanned data
        function updateBatchCode(data) {
            batchInput.value = data;
            currentScannedData = data;
            
            // Show scanned data in result area
            scannedDataSpan.textContent = data;
            resultArea.style.display = 'block';
            
            // Visual feedback
            batchInput.style.transform = 'scale(1.02)';
            batchInput.style.borderColor = '#28a745';
            setTimeout(() => {
                batchInput.style.transform = 'scale(1)';
                setTimeout(() => {
                    batchInput.style.borderColor = '#e0e0e0';
                }, 1000);
            }, 200);
            
            showStatus(`✅ Batch code scanned: "${data}"`, 'success');
        }

        // Function to extract batch code from QR data
        function extractBatchCode(rawData) {
            if (!rawData || rawData.trim() === '') {
                return null;
            }
            
            let cleaned = rawData.trim();
            
            // URL pattern extraction
            if (cleaned.match(/^https?:\/\//i)) {
                try {
                    const url = new URL(cleaned);
                    const batchParams = ['batch', 'batchcode', 'batch_code', 'batchCode', 'lot', 'lotno', 'lot_no', 'lotNumber', 'batchid', 'batch_id', 'code'];
                    for (let param of batchParams) {
                        if (url.searchParams.has(param)) {
                            const value = url.searchParams.get(param);
                            if (value && value.trim()) {
                                return value.trim();
                            }
                        }
                    }
                    const pathParts = url.pathname.split('/').filter(p => p);
                    for (let part of pathParts.reverse()) {
                        if (part.match(/^[A-Za-z0-9\-_]{4,30}$/)) {
                            return part;
                        }
                    }
                } catch(e) {}
            }
            
            // Batch code patterns
            const patterns = [
                /(?:batch|lot|code|batchcode|lotno)[:\s=]+([A-Za-z0-9\-_\.]{3,30})/i,
                /(?:BATCH|LOT|B|L)[\-_]?[0-9]{4,}[A-Z0-9\-_]{0,10}/i,
                /([A-Z]{2,4}[0-9]{4,8}[A-Z0-9\-_]*)/i,
                /([0-9]{4,8}[A-Z]{2,4}[A-Z0-9\-_]*)/i,
                /^([A-Za-z0-9\-_\.]{4,40})$/,
                /(20[0-9]{2}[0-1][0-9][0-3][0-9])/
            ];
            
            for (let pattern of patterns) {
                const match = cleaned.match(pattern);
                if (match) {
                    return match[1] || match[0];
                }
            }
            
            if (cleaned.length >= 3 && cleaned.length <= 100) {
                return cleaned;
            }
            
            return cleaned.length > 50 ? cleaned.substring(0, 50) : cleaned;
        }

        // Save to database via AJAX
        function saveToDatabase() {
            const batchCode = batchInput.value.trim();
            const additionalNotes = notes.value.trim();
            
            if (!batchCode) {
                showStatus('Please enter or scan a batch code first', 'error');
                return;
            }
            
            // Disable save button temporarily
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';
            
            $.ajax({
                url: 'save_batch.php',
                method: 'POST',
                data: {
                    batch_code: batchCode,
                    raw_qr_data: currentScannedData,
                    notes: additionalNotes
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showStatus('✅ ' + response.message, 'success');
                        notes.value = ''; // Clear notes after successful save
                        loadBatchRecords(); // Refresh the list
                        if (response.id) {
                            console.log('Saved with ID:', response.id);
                        }
                    } else {
                        showStatus('❌ Error: ' + response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    showStatus('❌ Error saving to database: ' + error, 'error');
                },
                complete: function() {
                    saveBtn.disabled = false;
                    saveBtn.textContent = '💾 Save to Database';
                }
            });
        }

        // Load batch records from database
        function loadBatchRecords() {
            batchList.innerHTML = '<div class="empty-state">Loading records...</div>';
            
            $.ajax({
                url: 'get_batches.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let html = '';
                        response.data.forEach(function(batch) {
                            html += `
                                <div class="batch-item">
                                    <div class="batch-code">${escapeHtml(batch.batch_code)}</div>
                                    <div class="batch-date">📅 ${formatDate(batch.scan_date)}</div>
                                    <div style="font-size: 12px; color: #666; margin-top: 5px;">
                                        Status: <span style="color: #28a745;">${batch.status}</span>
                                    </div>
                                </div>
                            `;
                        });
                        batchList.innerHTML = html;
                    } else {
                        batchList.innerHTML = '<div class="empty-state">📭 No batch records found</div>';
                    }
                },
                error: function() {
                    batchList.innerHTML = '<div class="empty-state">❌ Error loading records</div>';
                }
            });
        }

        // Export to CSV
        function exportToCSV() {
            window.location.href = 'export_csv.php';
        }

        // Helper function to escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Helper function to format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString();
        }

        // Clear form
        function clearForm() {
            batchInput.value = '';
            notes.value = '';
            currentScannedData = '';
            resultArea.style.display = 'none';
            batchInput.style.borderColor = '#e0e0e0';
            showStatus('Form cleared', 'info');
        }

        // QR Scanner functions
        async function startScanning() {
            if (isScanning) {
                showStatus('Scanner is already running', 'warning');
                return;
            }
            
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("reader");
            }
            
            const qrConfig = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };
            
            try {
                showStatus('📷 Requesting camera access...', 'info');
                
                const cameras = await Html5Qrcode.getCameras();
                if (!cameras || cameras.length === 0) {
                    showStatus('No cameras found', 'error');
                    return;
                }
                
                let cameraId = cameras[0].id;
                if (cameras.length > 1) {
                    const backCamera = cameras.find(cam => 
                        cam.label.toLowerCase().includes('back') || 
                        cam.label.toLowerCase().includes('rear')
                    );
                    if (backCamera) cameraId = backCamera.id;
                }
                
                await html5QrCode.start(cameraId, qrConfig, (decodedText) => {
                    const batchCode = extractBatchCode(decodedText);
                    if (batchCode) {
                        updateBatchCode(batchCode);
                        currentScannedData = decodedText;
                    } else {
                        showStatus('Could not extract batch code', 'warning');
                        scannedDataSpan.textContent = decodedText;
                        resultArea.style.display = 'block';
                    }
                }, (errorMessage) => {});
                
                isScanning = true;
                startBtn.style.display = 'none';
                stopBtn.style.display = 'inline-block';
                showStatus('📸 Scanner active', 'success');
                
            } catch (err) {
                console.error(err);
                showStatus('Error: ' + err.message, 'error');
            }
        }

        async function stopScanning() {
            if (html5QrCode && isScanning) {
                try {
                    await html5QrCode.stop();
                    isScanning = false;
                    startBtn.style.display = 'inline-block';
                    stopBtn.style.display = 'none';
                    showStatus('Scanner stopped', 'info');
                } catch (err) {
                    console.error(err);
                }
            }
        }

        // Event listeners
        startBtn.addEventListener('click', startScanning);
        stopBtn.addEventListener('click', stopScanning);
        saveBtn.addEventListener('click', saveToDatabase);
        clearBtn.addEventListener('click', clearForm);
        refreshBtn.addEventListener('click', loadBatchRecords);
        exportBtn.addEventListener('click', exportToCSV);
        
        // Load records on page load
        loadBatchRecords();
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (html5QrCode && isScanning) {
                html5QrCode.stop().catch(console.error);
            }
        });
    </script>
</body>
</html>