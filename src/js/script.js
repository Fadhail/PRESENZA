const video = document.getElementById('video');

// Fungsi untuk mengaktifkan kamera
async function setupCamera() {
    const stream = await navigator.mediaDevices.getUserMedia({
        video: { width: 720, height: 560 }
    });
    video.srcObject = stream;
    return new Promise((resolve) => {
        video.onloadedmetadata = () => {
            resolve(video);
        };
    });
}

// Memuat model face-api.js
async function loadModels() {
    await Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('../models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('../models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('../models'),
    ]);
    console.log("Models loaded successfully.");
}

// Inisialisasi kamera dan model
async function start() {
    await setupCamera();
    await loadModels();
    console.log("Camera and models are ready.");
}

start();

// Event untuk tombol pendaftaran wajah
const registerButton = document.getElementById('daftar');
registerButton.addEventListener('click', async () => {
    const faceDescriptor = await detectFace();
    if (faceDescriptor) {
        try {
            const response = await fetch('register_face.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    descriptor: Array.from(faceDescriptor)
                })
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
    }
});

// Deteksi wajah dan dapatkan deskriptor
async function detectFace() {
    const options = new faceapi.TinyFaceDetectorOptions();
    const detections = await faceapi
        .detectSingleFace(video, options)
        .withFaceLandmarks()
        .withFaceDescriptor();

    if (detections) {
        return detections.descriptor;
    }
    alert('No face detected. Please try again.');
    return null;
}

// Event untuk tombol pengenalan wajah
const recognizeButton = document.getElementById('recognize');
recognizeButton.addEventListener('click', async () => {
    const faceDescriptor = await detectFace();
    if (faceDescriptor) {
        try {
            const response = await fetch('recognize_face.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    descriptor: Array.from(faceDescriptor)
                })
            });

            if (response.ok) {
                const result = await response.json();
                if (result.label !== 'unknown') {
                    // Menampilkan nama dan NPM
                    alert(`Face recognized!\nName: ${result.name}\nNPM: ${result.npm}`);
                    markAttendance(result.name);
                } else {
                    alert('Face not recognized.');
                }
            } else {
                alert('Failed to recognize face.');
            }
        } catch (error) {
            console.error(error);
            alert('Error recognizing face.');
        }
    }
});

// Menandai kehadiran mahasiswa
function markAttendance(name) {
    fetch('mark_attendance.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name: name })
    }).then(response => {
        if (!response.ok) {
            alert('Failed to mark attendance.');
        }
    });
}
