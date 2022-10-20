@echo off

set conn=localhost
set db=PHP_API
set db_initial=master 
set usr=sa
set pwd=AStrongSAPwd

set connection_initial=-S %conn% -U %usr% -P %pwd% -d %db_initial%
set connection=-S %conn% -U %usr% -P %pwd%

echo Datenbank wird angelegt!
echo.

echo db_script.sql wird ausgeführt...
"sqlcmd" %connection% -i "db_script.sql"
echo.

echo Demodaten werden eingespielt!
echo.

echo demo_data.sql wird ausgeführt...
"sqlcmd" %connection% -i "demo_data.sql"
echo.

@echo on

pause


