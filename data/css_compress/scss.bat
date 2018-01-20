@ECHO OFF
IF NOT "%~f0" == "~f0" GOTO :WinNT
@"C:\TOOLS\Ruby\bin\ruby.exe" "C:/TOOLS/Ruby/bin/scss" %1 %2 %3 %4 %5 %6 %7 %8 %9
GOTO :EOF
:WinNT
@"C:\TOOLS\Ruby\bin\ruby.exe" "%~dpn0" %*
