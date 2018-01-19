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

fsource = str.replace(sys.argv[1], '\\', '/')  # scss
finput  = str.replace(sys.argv[2], '\\', '/')  # css
foutput = str.replace(sys.argv[3], '\\', '/')  # min.css
ftemp = '__temp_compresss_py_yui.tmp.css';

print('======== INPUT ========');
print();
print(fsource);
print(finput);
print(foutput);
print();
print();

print('======== CALL SCSS ========');
out = subprocess.run(['C:/TOOLS/Ruby/bin/scss.bat', '--no-cache', '--update', fsource + ':' + finput], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
print('> C:/TOOLS/Ruby/bin/scss.bat --no-cache --update ' + fsource + ':' + finput)
print('STDOUT:')
print(out.stdout.decode('utf-8'))
print('STDERR:')
print(out.stderr.decode('utf-8'))

print('')
print('')


print('======== CALL YUI ========');
out = subprocess.run(['java', '-jar', 'yuicompressor.jar', finput, '-o', ftemp], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
print('> java -jar yuicompressor.jar "'+finput+'" -o "'+ftemp+'"')
print('STDOUT:');
print(out.stdout.decode('utf-8'))
print('STDERR:');
print(out.stderr.decode('utf-8'))

print('')
print('')

print('======== READ ========');
with open(ftemp, 'r') as tf:
    data = tf.read()

print('')
print('')

print('======== REM ========');
try:
    os.remove(ftemp);
except e:
    print(e)

print('')
print('')

print('======== REGEX ========');
data = re.sub(r'(\}*\})', '\g<1>\n', data);

print('')
print('')

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

print('')
print('')

print('======== WRITE ========');
with open(foutput, "w") as tf:
    tf.write(data)

print('')
print('')
print('Sinished.')
