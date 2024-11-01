<?php

namespace App\Http\Resources\pengguna;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenggunaResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "message" => 'Data Berhasil ditemukan',
            "data" => [
                "id" => $this->id,
                "nama" => $this->nama,
                "nohp" => $this->nohp,
                "alamat" => $this->alamat,
                "foto" => $this->foto,
                "email" => $this->email,
            ]

        ];
    }
}
