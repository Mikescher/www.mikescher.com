#!/usr/bin/env python3

import sys
import os
from subprocess import call
import re
import subprocess

def findnext(str, start, chr):
    depth = 0
    for i in range(start, len(str)):
        if (str[i] == chr): return i;

def findclose(str, start):
    depth = 0
    for i in range(start, len(str)):
        if (str[i] == '{'): depth = depth+1;
        if (str[i] == '}'): depth = depth-1;
        if (depth == 0): return i;

def countnl(str, start, end):
    cnt = 0
    for i in range(start, end+1):
        if (str[i] == '\n'): cnt = cnt+1;
    return cnt;

finput  = str.replace(sys.argv[1], '\\', '/')
foutput = str.replace(sys.argv[2], '\\', '/')
ftemp = '__temp_compresss_py_yui.tmp.css';

print('======== INPUT ========');
print();
print(finput);
print(foutput);
print();
print();


print('======== CALL ========');
#os.system("java -jar yuicompressor.jar \""+finput+"\" -o \""+ftemp+"\"")
out = subprocess.run(['java', '-jar', 'yuicompressor.jar', finput, '-o', ftemp], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
print('STDOUT:');
print(out.stdout.decode('utf-8'))
print('STDERR:');
print(out.stderr.decode('utf-8'))

print('======== READ ========');
with open(ftemp, 'r') as tf:
    data = tf.read()

print('======== REM ========');
try:
    os.remove(ftemp);
except e:
    print(e)

print('======== REGEX ========');
data = re.sub(r'(\}*\})', '\g<1>\n', data);

print('======== MEDIA ========');
ins = []
for i in range(len(data)):
    if data[i:].startswith('@media'):


        copen = findnext(data, i, '{')
        cclose = findclose(data, copen)

        if (countnl(data, copen, cclose) == 0): continue;

        ins.append( (copen+1, '\n\t') )
        for i in range(copen+1, cclose):
            if data[i] == '\n':
                tp =(i+1, '\t')
                ins.append( tp )
        ins.append((cclose, '\n'))

for (l, c) in reversed(ins):
    data = data[:l] + c + data[l:]

print('======== WRITE ========');
with open(foutput, "w") as tf:
    tf.write(data)