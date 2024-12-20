document.addEventListener('DOMContentLoaded', async () => {
    // Element video, tombol, dan input NPM
    const video = document.getElementById('inputVideo');
    const registerButton = document.getElementById('daftar');
    const presensiButton = document.getElementById('presensi');
    const npmInput = document.getElementById('npm');

    let modelsLoaded = false; // Status pemuatan model

    // Fungsi untuk memuat model face-api.js
    async function loadModels() {
        try {
            console.log("Loading models...");
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri('../../../src/models'),
                faceapi.nets.faceLandmark68Net.loadFromUri('../../../src/models'),
                faceapi.nets.faceRecognitionNet.loadFromUri('../../../src/models'),
            ]);
            modelsLoaded = true;
            console.log("Models loaded successfully.");
        } catch (error) {
            ``
            console.error("Error loading models:", error);
        }
    }

    // Fungsi untuk mengaktifkan kamera
    async function setupCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
            video.srcObject = stream;
            await new Promise((resolve) => {
                video.onloadedmetadata = () => resolve();
            });
            console.log("Camera setup complete.");
        } catch (error) {
            console.error("Error setting up camera:", error);
        }
    }

    // Fungsi untuk deteksi wajah dan mengambil deskriptor
    async function detectFace() {
        if (!modelsLoaded) {
            alert("Models are not loaded yet. Please wait.");
            return null;
        }
        console.log("Detecting face...");
        const options = new faceapi.TinyFaceDetectorOptions();
        const detection = await faceapi.detectSingleFace(video, options).withFaceLandmarks().withFaceDescriptor();
        if (detection) {
            console.log("Face detected:", detection.descriptor);
            return detection.descriptor;
        }
        console.log("No face detected.");
        return null;
    }

    // Event handler untuk tombol "Register Face"
    registerButton.addEventListener('click', async () => {
        const faceDescriptor = await detectFace();
        const npm = npmInput.value.trim();
        if (!npm) {
            alert('Please enter your NPM.');
            return;
        }
        if (faceDescriptor) {
            try {
                const response = await fetch('../../../src/function/register_face.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ descriptor: Array.from(faceDescriptor), npm: npm })
                });

                if (response.ok) {
                    alert('Face descriptor registered successfully!');
                } else {
                    alert('Failed to register face descriptor.');
                }
            } catch (error) {
                console.error(error);
                alert('Error registering face descriptor.');
            }
        } else {
            alert('No face detected. Please try again.');
        }
    });

    // Fungsi untuk deteksi wajah dan mencocokkan dengan deskriptor di database
    async function detectAndMatchFace() {
        if (!modelsLoaded) {
            alert("Models are not loaded yet. Please wait.");
            return null;
        }
        console.log("Detecting face...");
        const options = new faceapi.TinyFaceDetectorOptions();
        const detection = await faceapi.detectSingleFace(video, options).withFaceLandmarks().withFaceDescriptor();
        if (detection) {
            console.log("Face detected:", detection.descriptor);
            const descriptor = Array.from(detection.descriptor);
            try {
                const response = await fetch('../../../src/function/match_face.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ descriptor: descriptor })
                });

                const result = await response.json();
                if (response.ok) {
                    return result;
                } else {
                    alert(result.message || 'Failed to match face descriptor.');
                    return null;
                }
            } catch (error) {
                console.error(error);
                alert('Error matching face descriptor.');
                return null;
            }
        } else {
            console.log("No face detected.");
            return null;
        }
    }

    // Event handler untuk tombol "Presensi"
    presensiButton.addEventListener('click', async () => {
        const result = await detectAndMatchFace();
        if (result && result.status === 'success') {
            alert('Presensi berhasil untuk NPM: ' + result.npm);
        } else {
            alert(result.message || 'Presensi gagal.');
        }
    });

    // Inisialisasi
    async function initialize() {
        await loadModels();
        await setupCamera();
    }

    initialize();
});