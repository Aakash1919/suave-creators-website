$productCss = [IO.File]::ReadAllText('D:\design\css\product.css')
$stylePath = 'd:\suave-creators\public\css\style.css'
$existing = [IO.File]::ReadAllText($stylePath)

if ($existing -notmatch '===== PRODUCT START =====') {
  $append = "`n/* ===== PRODUCT START ===== */`n$productCss`n/* ===== PRODUCT END ===== */`n"
  $utf8 = New-Object System.Text.UTF8Encoding $false
  [IO.File]::WriteAllText($stylePath, $existing + $append, $utf8)
  Write-Output 'Product CSS appended.'
} else {
  Write-Output 'Product CSS markers already present.'
}
