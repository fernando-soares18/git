$ErrorActionPreference = 'Stop'

$ink = 'C:\Program Files\Inkscape\bin\inkscape.com'
$out = 'C:\Users\Fernando\Pictures\logo-dr-charles-inpi\Modelos-Redondos'

if (-not (Test-Path $out)) {
    New-Item -ItemType Directory -Path $out | Out-Null
}

$models = @(
    'logo-dr-charles-round-1',
    'logo-dr-charles-round-2',
    'logo-dr-charles-round-3'
)

foreach ($m in $models) {
    $src = "C:\Users\Fernando\git\trabalho html\assets\$m.svg"
    $svg = Join-Path $out "$m.svg"
    $pdf = Join-Path $out "$m.pdf"
    $eps = Join-Path $out "$m.eps"
    $png = Join-Path $out "$m-10000px.png"
    $ai = Join-Path $out "$m.ai"

    Copy-Item -Force $src $svg

    & $ink $src --export-filename=$pdf --export-text-to-path | Out-Null
    & $ink $src --export-filename=$eps --export-text-to-path | Out-Null
    & $ink $src --export-filename=$png --export-width=10000 --export-background-opacity=0 | Out-Null

    Copy-Item -Force $pdf $ai
}

Get-ChildItem -Path $out | Select-Object Name | Sort-Object Name
