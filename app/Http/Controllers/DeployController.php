<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeployController extends Controller
{
    public function run()
    {
        // Kiểm tra quyền truy cập (quan trọng!)
        if (!app()->environment('local')) {
            abort(403, 'Unauthorized');
        }

        $projectBasePath = base_path(); // Laravel project root

        $commands = [
            'npm run build',
            'sudo systemctl restart php8.3-fpm',
            'sudo systemctl restart nginx',
            'sudo systemctl restart postgresql',
            'chmod -R 777 ' . $projectBasePath . '/storage',
            'php artisan optimize:clear',
        ];

        $output = [];

        foreach ($commands as $cmd) {
            // Di chuyển vào thư mục dự án trước khi chạy lệnh
            $fullCommand = "cd {$projectBasePath} && {$cmd}";
            $result = shell_exec($fullCommand . ' 2>&1');
            $output[] = [
                'command' => $fullCommand,
                'output' => $result,
            ];
        }

        return response()->json($output);
    }
}
