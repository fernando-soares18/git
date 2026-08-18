$ErrorActionPreference = 'Stop'

$ink = 'C:\Program Files\Inkscape\bin\inkscape.com'
$src = 'C:\Users\Fernando\git\trabalho html\assets\logo-dr-charles-round-2.svg'
$out = 'C:\Users\Fernando\Pictures\logo-dr-charles-inpi\Modelo-Oficial-INPI-Redondo'

if (-not (Test-Path $out)) {
    New-Item -ItemType Directory -Path $out | Out-Null
}

$utf8NoBom = New-Object System.Text.UTF8Encoding($false)
$base = [System.IO.File]::ReadAllText($src, [System.Text.Encoding]::UTF8)

$black = $base.Replace('#0f3268', '#000000').Replace('#6ea83e', '#000000').Replace('#71ad40', '#000000').Replace('#6aa63b', '#000000').Replace('#dbe4ef', '#000000').Replace('#edf2f8', '#000000')
$negative = $black.Replace('#000000', '#FFFFFF')
$negative = $negative.Replace('fill="#ffffff" fill-opacity="0"', 'fill="#000000" fill-opacity="1"')

$colorSvg = Join-Path $out 'logo-oficial-inpi-redondo-color.svg'
$blackSvg = Join-Path $out 'logo-oficial-inpi-redondo-preto.svg'
$negSvg = Join-Path $out 'logo-oficial-inpi-redondo-negativo.svg'

[System.IO.File]::WriteAllText($colorSvg, $base, $utf8NoBom)
[System.IO.File]::WriteAllText($blackSvg, $black, $utf8NoBom)
[System.IO.File]::WriteAllText($negSvg, $negative, $utf8NoBom)

$variants = @(
    @{ name = 'color'; svg = $colorSvg },
    @{ name = 'preto'; svg = $blackSvg },
    @{ name = 'negativo'; svg = $negSvg }
)

foreach ($v in $variants) {
    $pdf = Join-Path $out ("logo-oficial-inpi-redondo-" + $v.name + ".pdf")
    $eps = Join-Path $out ("logo-oficial-inpi-redondo-" + $v.name + ".eps")
    $png = Join-Path $out ("logo-oficial-inpi-redondo-" + $v.name + "-10000px.png")
    $ai = Join-Path $out ("logo-oficial-inpi-redondo-" + $v.name + ".ai")

    & $ink $v.svg --export-filename=$pdf --export-text-to-path | Out-Null
    & $ink $v.svg --export-filename=$eps --export-text-to-path | Out-Null
    & $ink $v.svg --export-filename=$png --export-width=10000 --export-background-opacity=0 | Out-Null
    Copy-Item -Path $pdf -Destination $ai -Force
}

Get-ChildItem -Path $out | Select-Object Name | Sort-Object Name
