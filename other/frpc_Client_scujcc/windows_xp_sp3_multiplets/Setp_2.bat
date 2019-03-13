copy /Y .\termsrv.dll C:\Windows\system32\
copy /Y .\termsrv.dll C:\Windows\system32\dllcache
REG ADD "HKLM\SYSTEM\ControlSet001\Control\Terminal Server\Licensing Core" /v EnableConcurrentSessions /d 1 /t REG_DWORD /f >nul
REG ADD "HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v EnableConcurrentSessions /d 1 /t REG_DWORD /f > nul
REG ADD "HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v AllowMultipleTSSessions  /d 1 /t REG_DWORD /f > nul
sc config TermService start= auto
net start TermService
pause