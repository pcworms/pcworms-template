SCAN_EXT = ("php","html","js","css")
KEYWORD_EXCLUD = ("bootstrap","git","bootswatch")

import colorama
import os
colorama.init()

print('step 1: finding all files')
files = []
keyw_check = lambda dir:not any(map(lambda keyw:keyw in dir,KEYWORD_EXCLUD))
ext_check = lambda file: any(map(lambda ext:file.endswith(ext),SCAN_EXT))
for root,names in [(root,filter(ext_check, files)) for root,dirs,files in os.walk('.') if keyw_check(root)]:
    files.extend(map(lambda file:os.path.join(root,file), names))

for i,file in enumerate(files):
    print(i,file)

inp = input("manual remove (sep:,): ")
if inp != '':
    for index in map(int,inp.split(',')):
        del files[index]