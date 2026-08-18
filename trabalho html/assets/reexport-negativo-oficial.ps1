$ink = 'C:\Program Files\Inkscape\bin\inkscape.com'
$base = 'C:\Users\Fernando\Pictures\logo-dr-charles-inpi\Modelo-Oficial-INPI-Redondo\logo-oficial-inpi-redondo-negativo'
$svg = "$base.svg"
$pdf = "$base.pdf"
$eps = "$base.eps"
$png = "$base-10000px.png"
$ai = "$base.ai"

& $ink $svg --export-filename=$pdf --export-text-to-path
& $ink $svg --export-filename=$eps --export-text-to-path
& $ink $svg --export-filename=$png --export-width=10000 --export-background-opacity=0
Copy-Item -Force $pdf $ai
