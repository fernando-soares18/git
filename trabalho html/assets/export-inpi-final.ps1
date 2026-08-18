$ErrorActionPreference = 'Stop'

$src = 'C:\Users\Fernando\git\trabalho html\assets\logo-dr-charles-inpi.svg'
$out = 'C:\Users\Fernando\Pictures\logo-dr-charles-inpi\INPI-final'
$ink = 'C:\Program Files\Inkscape\bin\inkscape.com'

if (-not (Test-Path $out)) {
    New-Item -ItemType Directory -Path $out | Out-Null
}

$latin1 = [System.Text.Encoding]::GetEncoding(1252)
$base = [System.IO.File]::ReadAllText($src, [System.Text.Encoding]::UTF8)
$base = $base.Replace('encoding="UTF-8"', 'encoding="ISO-8859-1"')
$saudeOtima = 'Sa' + [char]0x00FA + 'de ' + [char]0x00D3 + 'tima'
$cienciaTag = 'CI' + [char]0x00CA + 'NCIA, PREVEN' + [char]0x00C7 + [char]0x00C3 + 'O E LONGEVIDADE'
$base = $base.Replace('Sa&#250;de &#211;tima', $saudeOtima)
$base = $base.Replace('CI&#202;NCIA, PREVEN&#199;&#195;O E LONGEVIDADE', $cienciaTag)

$black = $base.Replace('stroke="url(#ringGrad)"', 'stroke="#000000"')
$black = $black.Replace('#0f3268', '#000000').Replace('#6ea83e', '#000000').Replace('#71ad40', '#000000').Replace('#6aa63b', '#000000')
$black = [regex]::Replace($black, '<defs>[\s\S]*?</defs>\s*', '')

$negative = $black.Replace('#000000', '#FFFFFF')
$negative = $negative.Replace('fill="#ffffff" fill-opacity="0"', 'fill="#000000" fill-opacity="1"')

[System.IO.File]::WriteAllText((Join-Path $out 'logo-dr-charles-inpi-color.svg'), $base, $latin1)
[System.IO.File]::WriteAllText((Join-Path $out 'logo-dr-charles-inpi-black.svg'), $black, $latin1)
[System.IO.File]::WriteAllText((Join-Path $out 'logo-dr-charles-inpi-negative.svg'), $negative, $latin1)

$variants = @('color', 'black', 'negative')

foreach ($variant in $variants) {
    $raw = Join-Path $out ("logo-dr-charles-inpi-$variant.svg")
    $pdf = Join-Path $out ("logo-dr-charles-inpi-$variant.pdf")
    $eps = Join-Path $out ("logo-dr-charles-inpi-$variant.eps")
    $png = Join-Path $out ("logo-dr-charles-inpi-$variant-10000px.png")
    $ai = Join-Path $out ("logo-dr-charles-inpi-$variant.ai")

    & $ink --batch-process --export-type=pdf --export-text-to-path ("--export-filename=$pdf") $raw | Out-Null
    & $ink --batch-process --export-type=eps --export-text-to-path ("--export-filename=$eps") $raw | Out-Null
    & $ink --batch-process --export-type=png ("--export-filename=$png") --export-width=10000 --export-background-opacity=0 $raw | Out-Null

    Copy-Item -Path $pdf -Destination $ai -Force
}

Get-ChildItem -Path $out | Select-Object Name | Sort-Object Name
