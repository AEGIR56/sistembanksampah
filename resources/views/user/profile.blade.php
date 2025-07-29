@extends('layouts.user')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Profil Saya</h1>

    {{-- 👤 Kartu Identitas User --}}
    <div style="background:#fff; box-shadow:0 2px 4px rgba(0,0,0,0.1); border-radius:8px; padding:24px; margin-bottom:32px;">
        <h2 style="font-size:1.125rem; font-weight:600; margin-bottom:16px;">Identitas</h2>
        <div style="line-height:1.8;">
            <p><strong>Nama:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Tanggal Bergabung:</strong> {{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>

    {{-- 🏆 Tabel Milestones --}}
    <div style="background:#fff; box-shadow:0 2px 4px rgba(0,0,0,0.1); border-radius:8px; padding:24px;">
        <h2 style="font-size:1.125rem; font-weight:600; margin-bottom:16px;">Pencapaian / Milestones</h2>

        @if ($milestones->isEmpty())
            <p style="color:#888;">Belum ada milestone yang tercatat.</p>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; text-align:left; font-size:0.9rem; border-collapse:collapse;">
                    <thead style="background:#f9f9f9;">
                        <tr>
                            <th style="padding:8px;">#</th>
                            <th style="padding:8px;">Nama Milestone</th>
                            <th style="padding:8px;">Status</th>
                            <th style="padding:8px;">Tanggal Tercapai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($milestones as $index => $milestone)
                            <tr
                                @if (!$milestone->achieved)
                                    style="background-color:#f0f0f0;"
                                @endif
                            >
                                <td style="padding:8px; border-bottom:1px solid #eee;">{{ $index + 1 }}</td>
                                <td style="padding:8px; border-bottom:1px solid #eee; text-transform:capitalize;">
                                    {{ str_replace('_', ' ', $milestone->type) }}
                                </td>
                                <td style="padding:8px; border-bottom:1px solid #eee;">
                                    @if ($milestone->achieved)
                                        <span style="color:green; font-weight:600;">✅ Tercapai</span>
                                    @else
                                        <span style="color:#888;">🔒 Belum</span>
                                    @endif
                                </td>
                                <td style="padding:8px; border-bottom:1px solid #eee;">
                                    @if ($milestone->achieved_at)
                                        {{ $milestone->achieved_at->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
