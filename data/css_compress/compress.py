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

def comment_remover(text):
    def replacer(match):
        s = match.group(0)
        if s.startswith('/'):
            return " " # note: a space and not an empty string
        else:
            return s
    pattern = re.compile(
        r'//.*?$|/\*.*?\*/|\'(?:\\.|[^\\\'])*\'|"(?:\\.|[^\\"])*"',
        re.DOTALL | re.MULTILINE
    )
    return re.sub(pattern, replacer, text)

fsource = str.replace(sys.argv[1], '\\', '/')  # scss
finput  = str.replace(sys.argv[2], '\\', '/')  # css
foutput = str.replace(sys.argv[3], '\\', '/')  # min.css
ftemp1 = '__temp_compresss_py_1.tmp.css';
ftemp2 = '__temp_compresss_py_2.tmp.css';

print('======== INPUT ========');
print();
print(fsource);
print(finput);
print(foutput);
print();
print();

print('======== DELETE OLD DATA ========');
if os.path.isfile(finput):
	try:
		os.remove(finput);
		print(finput + ' deleted')
	except e:
		print(e)
else:
		print(finput + ' does not exist')
if os.path.isfile(foutput):
	try:
		os.remove(foutput);
		print(foutput + ' deleted')
	except e:
		print(e)
else:
		print(foutput + ' does not exist')
print();
print();


print('======== CALL SCSS ========');
out = subprocess.run(['ruby', 'scss', '--style=expanded', '--no-cache', '--update', fsource + ':' + finput], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
print('> scss.bat --style=expanded --no-cache --update ' + fsource + ':' + finput)
print('STDOUT:')
print(out.stdout.decode('utf-8'))
print('STDERR:')
print(out.stderr.decode('utf-8'))

print('')
print('')

print('======== CLEANUP COMMENTS ========');
with open(finput, 'r') as tf:
    data1 = tf.read()
    print(str(len(data1)) + ' characters read from ' + os.path.basename(finput))

data1 = comment_remover(data1)
print('Comments in css removed');

with open(ftemp1, "w") as tf:
    tf.write(data1)
    print(str(len(data1)) + ' characters written to ' + ftemp1)

print('')
print('')


print('======== CALL YUI ========');
out = subprocess.run(['java', '-jar', 'yuicompressor.jar', '--verbose', ftemp1, '-o', ftemp2], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
print('> java -jar yuicompressor.jar --verbose "'+finput+'" -o "'+ftemp2+'"')
print('STDOUT:');
print(out.stdout.decode('utf-8'))
print('STDERR:');
print(out.stderr.decode('utf-8'))

print('')
print('')

print('======== READ ========');
with open(ftemp2, 'r') as tf:
    data = tf.read()
    print(str(len(data)) + ' characters read from ' + ftemp2)

print('')
print('')

print('======== REM ========');
try:
    os.remove(ftemp1);
    print(ftemp1 + ' deleted')
    os.remove(ftemp2);
    print(ftemp2 + ' deleted')
except e:
    print(e)

print('')
print('')

print('======== REGEX ========');
data = re.sub(r'(\}*\})', '\g<1>\n', data);

print('css data modified (1)')

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
        print('media query at idx:' + str(i) + ' formatted')

for (l, c) in reversed(ins):
    data = data[:l] + c + data[l:]

print('')
print('')

print('======== WRITE ========');
with open(foutput, "w") as tf:
    tf.write(data)
    print(str(len(data)) + ' characters written to ' + foutput)

print('')
print('')

print('======== REMOVE MAP ========');
if os.path.isfile(finput + '.map'):
	try:
		os.remove(finput + '.map');
		print(finput + '.map' + ' deleted')
	except e:
		print(e)
else:
		print(finput + '.map' + ' does not exist')

print('')
print('')


print('Finished.')
