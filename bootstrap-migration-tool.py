SCAN_EXT = ("php","html","js","css")
KEYWORD_EXCLUD = ("bootstrap","git","bootswatch")

import math
from turtle import back
from colorama import init,Back,Fore,Style
import os
from rules_v3_v4 import rules
import re
init()

for root,dirs,files in os.walk('.'):
    if any(keyw in root for keyw in KEYWORD_EXCLUD):
        continue
    for file in filter(lambda f: f.endswith(SCAN_EXT),files):
        file_path = os.path.join(root,file)
        print(Back.WHITE+Fore.BLACK+"Scanning file: "+file_path+Style.RESET_ALL,'\n')
        with open(file_path,"r",encoding='utf-8') as f:
            for i,line in enumerate(f):
                line = line.strip()
                for r,rule in enumerate(rules):
                    match = re.search(rule['reg'],line)
                    if match:
                        color = ''
                        back_color=''
                        if rule['lvl']=='error':
                            back_color = Back.RED
                            color = Fore.RED
                        elif rule['lvl']=='warn':
                            back_color = Back.YELLOW
                            color = Fore.YELLOW

                        print(back_color+Fore.BLACK,'rule',r,rule['lvl'],file_path+f':{i+1}',Style.RESET_ALL)
                        print('\t',line[:match.start()]+back_color+Fore.BLACK+match.group()+Style.RESET_ALL+line[match.end():])
                        
                        print(color+rule['msg']+Style.RESET_ALL+'\n')
                        if rule['lvl']=='error':
                            input()
            print("Completed\n")