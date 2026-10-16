<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>QR Scanner - Scan & Save</title>
   
    <style>
        /* Only minimal custom styles needed */
        #reader {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            display: none;
        }

        .scanned-input:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
        <form method="post" id="storeForm">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="text-center mb-2">Add Store Detail</h1>

                          
                            
                            <div class="form-group">
                                <label>Select storage type</label>
                                <select name="storeid" id="storeid" class="form-control" required>
                                    <option value="Egg Storage">Egg Storage</option>
                                    <option value="Ambient Storage">Ambient Storage</option>
                                    <option value="Freezer Storage">Freezer Storage</option>
                                    <option value="Chiller Storage">Chiller Storage</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Grn Code:</label>
                                <input type="text" id="scannedData" class="form-control scanned-input" placeholder="Scan a QR code..." name="grncode" required>
                            </div>
                              <div class="mb-3">
                                <div id="reader"></div>
                                <div class="btn-group w-100 mb-3">
                                    <button type="button" id="startScanBtn" class="btn btn-success">🔍 Start Scanner</button>
                                    <button type="button" id="stopScanBtn" class="btn btn-danger" style="display:none;">⏹️ Stop</button>
                                </div>
                            </div>

                            <button type="submit" id="saveBtn" class="btn btn-primary btn-lg btn-block" name="submit">💾 Submit / Save</button>

                            <div id="status" class="alert alert-info mt-3 mb-0">
                                💡 Click "Start Scanner" and allow camera
                            </div>

                            <div id="savedBox" class="alert alert-success mt-3" style="display:none;">
                                <strong>✅ Last Saved:</strong><br>
                                <div id="savedContent" class="mt-1"></div>
                                <button type="button" id="clearSavedBtn" class="btn btn-sm btn-secondary mt-2" style="display:none;">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        // DOM Elements
        const startBtn = document.getElementById('startScanBtn');
        const stopBtn = document.getElementById('stopScanBtn');
        const scannedInput = document.getElementById('scannedData');
        const statusDiv = document.getElementById('status');
        const savedBox = document.getElementById('savedBox');
        const savedContent = document.getElementById('savedContent');
        const clearSavedBtn = document.getElementById('clearSavedBtn');
        const readerDiv = document.getElementById('reader');
        const storeForm = document.getElementById('storeForm');

        // Variables
        let html5QrCode = null;
        let isScanning = false;
        let currentScannedValue = '';

        // Show status message
        function showStatus(message, type = 'info') {
            statusDiv.className = `alert alert-${type} mt-3 mb-0`;
            statusDiv.innerHTML = message;

            if (type === 'success' || type === 'error') {
                setTimeout(() => {
                    if (statusDiv.className.includes(type) && !isScanning) {
                        statusDiv.className = 'alert alert-info mt-3 mb-0';
                        statusDiv.innerHTML = '✅ Ready - Start scanner to scan more';
                    }
                }, 3000);
            }
        }

        // Extract batch code from QR data
        function extractBatchCode(rawData) {
            if (!rawData || rawData.trim() === '') return null;

            let cleaned = rawData.trim();

            // URL pattern extraction
            if (cleaned.match(/^https?:\/\//i)) {
                try {
                    const url = new URL(cleaned);
                    const batchParams = ['batch', 'batchcode', 'batch_code', 'batchCode', 'lot', 'lotno', 'code', 'id', 'data', 'grn', 'grncode'];
                    for (let param of batchParams) {
                        if (url.searchParams.has(param)) {
                            const value = url.searchParams.get(param);
                            if (value && value.trim()) return value.trim();
                        }
                    }
                    const pathParts = url.pathname.split('/').filter(p => p);
                    for (let part of pathParts.reverse()) {
                        if (part.match(/^[A-Za-z0-9\-_]{3,50}$/)) return part;
                    }
                } catch (e) {}
            }

            // If it's a simple code (letters, numbers, hyphens, underscores)
            if (cleaned.match(/^[A-Za-z0-9\-_\.]{3,100}$/)) {
                return cleaned;
            }

            // Return as is if not too long
            return cleaned.length > 100 ? cleaned.substring(0, 100) : cleaned;
        }

        // Update input field with scanned data
        function updateScannedData(data) {
            currentScannedValue = data;
            scannedInput.value = data;
            
            // Visual feedback
            scannedInput.classList.add('is-valid');
            setTimeout(() => {
                scannedInput.classList.remove('is-valid');
            }, 1000);

            showStatus(`✅ QR Scanned: "${data}"`, 'success');
        }

        // Stop scanner
        async function stopScanner() {
            if (html5QrCode && isScanning) {
                try {
                    await html5QrCode.stop();
                    isScanning = false;
                    readerDiv.style.display = 'none';
                    startBtn.style.display = 'block';
                    stopBtn.style.display = 'none';
                    showStatus('⏹️ Scanner stopped', 'info');
                } catch (err) {
                    console.error('Stop error:', err);
                }
            }
        }

        // Start scanner - scans ONE QR and stops automatically
        async function startScanner() {
            if (isScanning) {
                showStatus('Scanner is already running', 'warning');
                return;
            }

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("reader");
            }

            const qrConfig = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                },
                aspectRatio: 1.0
            };

            try {
                showStatus('📷 Requesting camera access...', 'info');

                const cameras = await Html5Qrcode.getCameras();
                if (!cameras || cameras.length === 0) {
                    showStatus('No camera found on this device', 'danger');
                    return;
                }

                // Select back camera if available
                let cameraId = cameras[0].id;
                if (cameras.length > 1) {
                    const backCamera = cameras.find(cam =>
                        cam.label.toLowerCase().includes('back') ||
                        cam.label.toLowerCase().includes('rear') ||
                        cam.label.toLowerCase().includes('environment')
                    );
                    if (backCamera) cameraId = backCamera.id;
                }

                readerDiv.style.display = 'block';

                await html5QrCode.start(cameraId, qrConfig, (decodedText) => {
                    // Process the scanned QR
                    const batchCode = extractBatchCode(decodedText);
                    if (batchCode) {
                        updateScannedData(batchCode);
                        // Stop scanner after ONE successful scan
                        stopScanner();
                    } else {
                        showStatus('Could not extract data from QR', 'warning');
                    }
                }, (errorMessage) => {
                    // Silent error handling for scanning attempts
                });

                isScanning = true;
                startBtn.style.display = 'none';
                stopBtn.style.display = 'block';
                showStatus('📸 Scanner active - Scan ONE QR code', 'success');

            } catch (err) {
                console.error('Scanner error:', err);
                readerDiv.style.display = 'none';
                if (err.toString().includes('NotAllowedError')) {
                    showStatus('Camera permission denied. Please allow camera access.', 'danger');
                } else {
                    showStatus('Error: ' + err.message, 'danger');
                }
            }
        }

        // Save the scanned data (for display only, form will submit to PHP)
        function displaySavedData(data) {
            const storeType = document.getElementById('storeid').value;
            savedContent.innerHTML = `
                <strong>${escapeHtml(data)}</strong><br>
                <small class="text-muted">Storage: ${escapeHtml(storeType)}</small><br>
                <small class="text-muted">Saved at: ${new Date().toLocaleString()}</small>
            `;
            savedBox.style.display = 'block';
            clearSavedBtn.style.display = 'block';
        }

        // Clear saved display
        function clearSaved() {
            savedBox.style.display = 'none';
            clearSavedBtn.style.display = 'none';
            showStatus('Cleared saved data', 'info');
        }

        // Escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Handle form submission
        function handleFormSubmit(event) {
            const grnCode = scannedInput.value.trim();
            const storeType = document.getElementById('storeid').value;
            
            if (!grnCode) {
                event.preventDefault();
                showStatus('Please scan a GRN code first', 'danger');
                return false;
            }
            
            if (!storeType) {
                event.preventDefault();
                showStatus('Please select storage type', 'danger');
                return false;
            }
            
            // Display saved data before form submission
            displaySavedData(grnCode);
            showStatus('Submitting to database...', 'info');
            
            // Allow form to submit
            return true;
        }

        // Event listeners
        startBtn.addEventListener('click', startScanner);
        stopBtn.addEventListener('click', stopScanner);
        clearSavedBtn.addEventListener('click', clearSaved);
        
        // Form submission handler
        storeForm.addEventListener('submit', handleFormSubmit);

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (html5QrCode && isScanning) {
                html5QrCode.stop().catch(console.error);
            }
        });

        // Test function for console
        window.testScan = function(data) {
            updateScannedData(data);
            stopScanner();
        };

        console.log('QR Scanner Ready - Scans ONE QR at a time');
    </script>

    <?php
   
  
    if(isset($_POST['submit']))
    {
        $grnc = mysqli_real_escape_string($con, $_POST['grncode']);
        $storeid = mysqli_real_escape_string($con, $_POST['storeid']);
        
        // Check if GRN exists in tblgrn1
        $grnql = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE grn='$grnc'");
        
        if(mysqli_num_rows($grnql) > 0) {
            $grnql1 = mysqli_fetch_array($grnql);
            $grnid = $grnql1['id'];
            $cdate = date("Y-m-d H:i:s");
            $cuser = $_SESSION['user'];
            
            
            $grninsert = mysqli_query($con , "INSERT INTO `tbl_store`(`store`, `grnid`, `grn`, `user`, `udate`) VALUES ('$storeid','$grnid','$grnc','$cuser','$cdate')");
            
            if($grninsert){
                echo "<script>
                    alert('GRN Created Successfully');
                    window.location.href = 'admin.php?id=storein1';
                </script>";
            }
        } else {
            echo "<script>alert('GRN Code not found in database');</script>";
        }
    }
    ?>
</body>
</html>