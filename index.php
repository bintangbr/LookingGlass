<?php

function executeCommand($command, $parameter, $protocol) {
    $allowedCommands = ['ping', 'traceroute']; //perintah yg di allow

    if (!in_array($command, $allowedCommands)) {
        return "Perintah tidak diizinkan.";
    }

    $parameter = escapeshellarg($parameter);

    if ($command === 'ping') {
        if ($protocol === 'ipv4') {
            $finalCommand = "ping -4 -c 5 $parameter 2>&1";
        } elseif ($protocol === 'ipv6') {
            $finalCommand = "ping -6 -c 5 $parameter 2>&1";
        } else {
            $finalCommand = "ping -c 5 $parameter 2>&1";
        }
    } elseif ($command === 'traceroute') {
        if ($protocol === 'ipv4') {
            $finalCommand = "traceroute -4 $parameter 2>&1";
        } elseif ($protocol === 'ipv6') {
            $finalCommand = "traceroute -6 $parameter 2>&1";
        } else {
            $finalCommand = "traceroute $parameter 2>&1";
        }
    }

    $output = shell_exec($finalCommand);

    if ($output === null) {
        return "Terjadi kesalahan saat menjalankan perintah.";
    }

    return nl2br(htmlspecialchars($output));
}

$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'] ?? '';
    $parameter = $_POST['parameter'] ?? '';
    $protocol = $_POST['protocol'] ?? '';
    $result = executeCommand($command, $parameter, $protocol);
}

function getClientIPInfo() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $apiKey = '[TOKEN-IPINFO-KAMUU]';
    $url = "https://ipinfo.io/{$ip}?token={$apiKey}";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    if ($response) {
        $data = json_decode($response, true);
        return [
            'ip' => $ip,
            'owner' => $data['org'] ?? 'Unknown IP',
        ];
    }

    return ['ip' => $ip, 'owner' => 'Unknown Owner'];
}

$ipInfo = getClientIPInfo();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Looking Glass - Linkbit Inovasi Teknologi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://linkbit.net.id/assets/img/favicon.ico" rel="icon">
    <meta name="author" content="https://github.com/bintangbr" />
</head>
<body>
<div class="container mt-5">
    <div class="text-center mb-4">
        <h1><i class="fas fa-network-wired"></i> Looking Glass - Network Tools</h1>
        <p class="text-muted">Tes koneksi jaringan dengan mudah menggunakan Ping atau Traceroute.</p>
    </div>

    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <h3 class="text-center mb-3">Network Information</h3>
            <ul class="list-unstyled">
                <li><strong>Server Location:</strong> Purwodadi, Central Java, Indonesia</li>
                <li><strong>Test IPv4:</strong> 103.190.112.100</li>
                <li><strong>Test IPv6:</strong> 2001:df08::</li>
                <li><strong>Test Files:</strong> 
                    <a href="100MB.test">100MB</a>, 
                    <a href="1000MB.test">1000MB</a>
                </li>
                <li>
                    <strong>Your IP Address:</strong> 
                    <?= htmlspecialchars($ipInfo['ip']) ?> 
                    (<em><?= htmlspecialchars($ipInfo['owner']) ?></em>)
                </li>
            </ul>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <h3 class="text-center mb-3">Network Tests</h3>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="command" class="form-label">Pilih Perintah</label>
                    <select class="form-select" name="command" id="command" required>
                        <option value="ping">Ping</option>
                        <option value="traceroute">Traceroute</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="protocol" class="form-label">Pilih Protokol</label>
                    <select class="form-select" name="protocol" id="protocol" required>
                        <option value="">Pilih Protokol</option>
                        <option value="ipv4">IPv4</option>
                        <option value="ipv6">IPv6</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="parameter" class="form-label">Masukkan IP atau Hostname</label>
                    <input type="text" class="form-control" id="parameter" name="parameter" placeholder="Contoh: 8.8.8.8" required>
                    <div class="invalid-feedback">Masukkan alamat IP atau hostname yang valid.</div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-play-circle"></i> Jalankan</button>
                </div>
            </form>

            <?php if (!empty($result)): ?>
                <div class="mt-4">
                    <h3 class="text-center">Hasil:</h3>
                    <pre class="bg-light p-3 border"> <?= htmlspecialchars($result) ?> </pre>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="text-center mt-4">
        <p>&copy; 2022-2025 NOC Linkbit Inovasi Teknologi</p>
        <p>Develop by <a href="https://github.com/bintangbr">Bintanggg</a></p>
    </footer>
</div>

<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
