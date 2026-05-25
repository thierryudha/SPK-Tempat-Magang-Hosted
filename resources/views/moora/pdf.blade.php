<style>
    body { font-family: 'Helvetica', sans-serif; color: #0f172a; line-height: 1.5; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 11px; table-layout: fixed; }
    th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: center; word-wrap: break-word; }
    th { background-color: #0f172a; font-weight: bold; color: #ffffff; text-transform: uppercase; letter-spacing: 1px; }
    .header { text-align: center; margin-bottom: 40px; border-bottom: 4px solid #2563eb; padding-bottom: 20px; }
    .header h1 { margin-bottom: 8px; font-size: 24px; color: #0f172a; text-transform: uppercase; font-weight: 900; }
    .header p { color: #475569; font-size: 12px; margin: 4px 0; font-weight: bold; }
    .footer { text-align: right; margin-top: 40px; font-size: 10px; color: #94a3b8; border-top: 2px solid #f1f5f9; padding-top: 15px; }
    .rank-1 { background-color: #fefce8; font-weight: bold; }
    h2 { font-size: 16px; color: #0f172a; border-left: 6px solid #2563eb; padding-left: 15px; margin-top: 40px; margin-bottom: 20px; background: #f8fafc; padding-top: 10px; padding-bottom: 10px; text-transform: uppercase; font-weight: 900; }
    .formula { font-style: italic; color: #2563eb; font-size: 10px; margin-bottom: 12px; display: block; font-weight: bold; }
    .step-num { background: #2563eb; color: white; padding: 3px 10px; border-radius: 6px; margin-right: 8px; font-size: 13px; }
    .benefit { color: #059669; font-weight: bold; }
    .cost { color: #dc2626; font-weight: bold; }
    .highlight { color: #2563eb; font-weight: bold; }
</style>

<div class="header">
    <h1>LAPORAN HASIL ANALISIS MOORA</h1>
    <p>Sistem Pendukung Keputusan Pemilihan Tempat Magang Terintegrasi</p>
    <p>Tanggal Laporan: {{ now()->format('d F Y, H:i') }}</p>
    <p>Nama Pengguna: {{ auth()->user()->name }}</p>
</div>

<!-- STEP 1: Decision Matrix -->
<h2><span class="step-num">1</span> Matriks Keputusan (X)</h2>
<span class="formula">Langkah awal: Pemetaan skor mentah dari setiap alternatif terhadap kriteria.</span>
<table>
    <thead>
        <tr>
            <th style="width: 25%">Alternatif</th>
            @foreach($criterias as $c)
                <th>{{ $c->code }}<br><small>({{ strtoupper(substr($c->type, 0, 1)) }})</small></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($results as $res)
        <tr>
            <td style="text-align: left; font-weight: bold; background: #f8fafc;">{{ $res['name'] }}</td>
            @foreach($criterias as $c)
                <td>{{ $res['scores'][$c->id] }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<!-- STEP 2: Normalization Matrix -->
<h2><span class="step-num">2</span> Matriks Normalisasi (R)</h2>
<span class="formula">Rumus: r<sub>ij</sub> = x<sub>ij</sub> / √[Σx<sub>ij</sub>²]</span>
<table>
    <thead>
        <tr>
            <th style="width: 25%">Alternatif</th>
            @foreach($criterias as $c)
                <th>{{ $c->code }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($results as $res)
        <tr>
            <td style="text-align: left; font-weight: bold; background: #f8fafc;">{{ $res['name'] }}</td>
            @foreach($criterias as $c)
                <td class="highlight">{{ number_format($res['normalized_scores'][$c->id]['normalized'], 4) }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<div style="page-break-after: always;"></div>

<!-- STEP 3: Weighted Normalization -->
<h2><span class="step-num">3</span> Normalisasi Terbobot (Y)</h2>
<span class="formula">Rumus: y<sub>ij</sub> = r<sub>ij</sub> × w<sub>j</sub> (Berdasarkan bobot prioritas Anda)</span>
<table>
    <thead>
        <tr>
            <th style="width: 25%">Alternatif</th>
            @foreach($criterias as $c)
                <th>{{ $c->code }}<br><small>({{ $c->weight }}%)</small></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($results as $res)
        <tr>
            <td style="text-align: left; font-weight: bold; background: #f8fafc;">{{ $res['name'] }}</td>
            @foreach($criterias as $c)
                <td style="color: #4f46e5; font-weight: bold;">{{ number_format($res['normalized_scores'][$c->id]['weighted'], 4) }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<!-- STEP 4: Optimization Value -->
<h2><span class="step-num">4</span> Perhitungan Nilai Optimasi (Yi)</h2>
<span class="formula">Rumus: Yi = Σ[Benefit] - Σ[Cost]</span>
<table>
    <thead>
        <tr>
            <th style="width: 30%">Alternatif</th>
            <th style="width: 23%">Max (Benefit)</th>
            <th style="width: 23%">Min (Cost)</th>
            <th style="width: 24%">Nilai Yi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $res)
            @php
                $max = 0; $min = 0;
                foreach($criterias as $c) {
                    $val = $res['normalized_scores'][$c->id]['weighted'];
                    if($c->type === 'benefit') $max += $val;
                    else $min += $val;
                }
            @endphp
        <tr>
            <td style="text-align: left; font-weight: bold; background: #f8fafc;">{{ $res['name'] }}</td>
            <td class="benefit">{{ number_format($max, 4) }}</td>
            <td class="cost">{{ number_format($min, 4) }}</td>
            <td style="font-weight: 900; color: #1e40af; background: #eff6ff;">{{ number_format($res['optimization_value'], 4) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- STEP 5: Final Ranking -->
<h2><span class="step-num">5</span> Kesimpulan Perankingan Akhir</h2>
<span class="formula">Hasil akhir urutan tempat magang terbaik berdasarkan preferensi kriteria Anda.</span>
<table>
    <thead>
        <tr>
            <th style="width: 15%">Rank</th>
            <th style="width: 55%">Nama Tempat Magang</th>
            <th style="width: 30%">Skor Akhir (Yi)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $res)
        <tr class="{{ $res['rank'] == 1 ? 'rank-1' : '' }}">
            <td style="font-size: 14px; font-weight: 900;">#{{ $res['rank'] }}</td>
            <td style="text-align: left; font-weight: bold;">{{ strtoupper($res['name']) }}</td>
            <td style="font-weight: 900; color: #1e40af;">{{ number_format($res['optimization_value'], 4) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Dokumen ini dihasilkan secara sistematis oleh MooraProject Intelligence System.<br>
    &copy; {{ date('Y') }} MooraProject - High Performance Decision Support System.
</div>
