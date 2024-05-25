<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $role = $session->get('role');

        if (!$role) {
            return redirect()->to('/'); // Jika tidak ada role, arahkan ke halaman login
        }

        if ($arguments && !in_array($role, $arguments)) {
            // Jika role tidak cocok dengan salah satu dari argument yang diberikan
            return redirect()->to('/unauthorized'); // Halaman unauthorized
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan tindakan setelah request di sini
    }
}
