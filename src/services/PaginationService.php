<?php
namespace App\Service;

class PaginationService
{
    public function paginate(int $total, int $perPage, int $currentPage): array
    {
        $totalPages = (int) ceil($total / $perPage);
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset = ($currentPage - 1) * $perPage;

        return [
            'limit' => $perPage,
            'offset' => $offset,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalItems' => $total,
        ];
    }
}
