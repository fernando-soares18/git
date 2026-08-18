$ErrorActionPreference = 'Stop'

$ink = 'C:\Program Files\Inkscape\bin\inkscape.com'
$src = 'C:\Users\Fernando\git\trabalho html\assets\logo-dr-charles-horizontal-oficial.svg'
$out = 'C:\Users\Fernando\Pictures\logo-dr-charles-inpi\Logo-Horizontal-Oficial'

if (-not (Test-Path $out)) {
    New-Item -ItemType Directory -Path $out | Out-Null
}

$svg = Join-Path $out 'logo-dr-charles-horizontal-oficial.svg'
$pdf = Join-Path $out 'logo-dr-charles-horizontal-oficial.pdf'
$eps = Join-Path $out 'logo-dr-charles-horizontal-oficial.eps'
$png = Join-Path $out 'logo-dr-charles-horizontal-oficial-10000px.png'
$ai = Join-Path $out 'logo-dr-charles-horizontal-oficial.ai'

Copy-Item -Force $src $svg

& $ink $src --export-filename=$pdf --export-text-to-path | Out-Null
& $ink $src --export-filename=$eps --export-text-to-path | Out-Null
& $ink $src --export-filename=$png --export-width=10000 --export-background-opacity=0 | Out-Null
Copy-Item -Force $pdf $ai

Get-ChildItem -Path $out | Select-Object Name | Sort-Object Name
