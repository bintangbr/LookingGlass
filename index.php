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

    // Hapus nl2br() dan cukup gunakan htmlspecialchars()
    return htmlspecialchars($output);
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://linkbit.net.id/assets/img/favicon.ico" rel="icon">
    <meta name="author" content="https://github.com/bintangbr" />
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <img src="https://dashboard-staging.linkbit.net.id/assets/image/logo.png" alt="Logo" class="mx-auto h-20 mb-4">
        <h1 class="text-3xl font-bold text-gray-800"><i class="fas fa-network-wired"></i> Looking Glass - Network Tools</h1>
        <p class="text-gray-600">Tes koneksi jaringan dengan mudah menggunakan Ping atau Traceroute.</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg mb-8 p-6">
        <h3 class="text-center text-2xl font-semibold mb-4">Network Information</h3>
        <ul class="space-y-2">
            <li><strong>Server Location:</strong> Purwodadi, Central Java, Indonesia</li>
            <li><strong>Test IPv4:</strong> 103.190.112.100</li>
            <li><strong>Test IPv6:</strong> 2001:df08::</li>
            <li><strong>Test Files:</strong> 
                <a href="100MB.test" class="text-blue-500 hover:underline">100MB</a>, 
                <a href="1000MB.test" class="text-blue-500 hover:underline">1000MB</a>
            </li>
            <li>
                <strong>Your IP Address:</strong> 
                <?= htmlspecialchars($ipInfo['ip']) ?> 
                (<em><?= htmlspecialchars($ipInfo['owner']) ?></em>)
            </li>
        </ul>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-center text-2xl font-semibold mb-4">Network Tests</h3>
        <form method="POST" class="space-y-4">
            <div>
                <label for="command" class="block text-sm font-medium text-gray-700">Pilih Perintah</label>
                <select class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" name="command" id="command" required>
                    <option value="ping">Ping</option>
                    <option value="traceroute">Traceroute</option>
                </select>
            </div>
            <div>
                <label for="protocol" class="block text-sm font-medium text-gray-700">Pilih Protokol</label>
                <select class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" name="protocol" id="protocol" required>
                    <option value="">Pilih Protokol</option>
                    <option value="ipv4">IPv4</option>
                    <option value="ipv6">IPv6</option>
                </select>
            </div>
            <div>
                <label for="parameter" class="block text-sm font-medium text-gray-700">Masukkan IP atau Hostname</label>
                <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" id="parameter" name="parameter" placeholder="Contoh: 8.8.8.8" required>
                <div class="text-sm text-red-600">Masukkan alamat IP atau hostname yang valid.</div>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"><i class="fas fa-play-circle"></i> Jalankan</button>
            </div>
        </form>

        <?php if (!empty($result)): ?>
            <div class="mt-6">
                <h3 class="text-center text-2xl font-semibold mb-4">Hasil:</h3>
                <pre class="bg-gray-100 p-4 rounded-md border border-gray-200"> <?= htmlspecialchars($result) ?> </pre>
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center mt-8 text-gray-600">
        <p>&copy; 2022-2025 developers.linkbit.net.id</p>
        <p>Develop by <a href="https://github.com/bintangbr" class="text-blue-500 hover:underline">Bintanggg</a></p>
    </footer>
</div>

<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('form')
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
</body>
</html>
