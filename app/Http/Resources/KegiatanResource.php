<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KegiatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'tahun' => $this->tahun,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_mulai_raw' => $this->waktu_mulai->format('Y-m-d'),
            'waktu_selesai' => $this->waktu_selesai,
            'waktu_selesai_raw' => $this->waktu_selesai->format('Y-m-d'),
            'kandidat' => KandidatResource::collection($this->whenLoaded('kandidat')),
        ];
    }
}
