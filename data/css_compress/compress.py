#!/usr/bin/env python3

import sys
import os
import re
import subprocess
import shutil


def findnext(strdata, start, searchchr):
    depth = 0
    for i in range(start, len(strdata)):
        if strdata[i] == searchchr: return i;


def findclose(strdata, start):
    depth = 0
    for i in range(start, len(strdata)):
        if strdata[i] == '{': depth = depth + 1;
        if strdata[i] == '}': depth = depth - 1;
        if depth == 0: return i;


def countnl(strdata, start, end):
    cnt = 0
    for i in range(start, end + 1):
        if strdata[i] == '\n': cnt = cnt + 1;
    return cnt


def comment_remover(text):
    def replacer(match):
        s = match.group(0)
        if s.startswith('/'):
            return " "  # note: a space and not an empty string
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
ftemp1  = '__temp_compresss_py_1.tmp.css'
ftemp2  = '__temp_compresss_py_2.tmp.css'

print('======== INPUT ========')
print()
print(fsource)
print(finput)
print(foutput)
print()
print()

print('======== DELETE OLD DATA ========')
if os.path.isfile(finput):
    try:
        os.remove(finput)
        print(finput + ' deleted')
    except:
        print(sys.exc_info()[0])
else:
    print(finput + ' does not exist')
if os.path.isfile(foutput):
    try:
        os.remove(foutput)
        print(foutput + ' deleted')
    except:
        print(sys.exc_info()[0])
else:
    print(foutput + ' does not exist')
print()
print()

print('======== CALL SCSS ========')
print('> scss --style=expanded --no-cache --update "' + fsource + ':' + finput + '"')
out = subprocess.run([shutil.which('scss'), '--style=expanded', '--no-cache', '--update', fsource + ':' + finput], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
print('STDOUT:')
print(out.stdout.decode('utf-8'))
print('STDERR:')
print(out.stderr.decode('utf-8'))

print('')
print('')

print('======== CLEANUP COMMENTS ========')
with open(finput, 'r') as tf:
    data1 = tf.read()
    print(str(len(data1)) + ' characters read from ' + os.path.basename(finput))

data1 = comment_remover(data1)
print('Comments in css removed')

with open(ftemp1, "w") as tf:
    tf.write(data1)
    print(str(len(data1)) + ' characters written to ' + ftemp1)

print('')
print('')

print('======== CALL YUI ========')
print('> java -jar yuicompressor.jar --verbose "' + finput + '" -o "' + ftemp2 + '"')
out = subprocess.run(['java', '-jar', 'yuicompressor.jar', '--verbose', ftemp1, '-o', ftemp2], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
print('STDOUT:')
print(out.stdout.decode('utf-8'))
print('STDERR:')
print(out.stderr.decode('utf-8'))

print('')
print('')

print('======== READ ========')
with open(ftemp2, 'r') as tf:
    data = tf.read()
    print(str(len(data)) + ' characters read from ' + ftemp2)

print('')
print('')

print('======== REM ========')
try:
    os.remove(ftemp1)
    print(ftemp1 + ' deleted')
    os.remove(ftemp2)
    print(ftemp2 + ' deleted')
except:
    print(sys.exc_info()[0])

print('')
print('')

print('======== REGEX ========')
data = re.sub(r'(\}*\})', '\g<1>\n', data)

print('css data modified (1)')

print('')
print('')

print('======== MEDIA ========')
ins = []
for i in range(len(data)):
    if data[i:].startswith('@media'):

        copen = findnext(data, i, '{')
        cclose = findclose(data, copen)

        if countnl(data, copen, cclose) == 0: continue;

        ins.append((copen + 1, '\n\t'))
        for i2 in range(copen + 1, cclose):
            if data[i2] == '\n':
                tp = (i2 + 1, '\t')
                ins.append(tp)
        ins.append((cclose, '\n'))
        print('media query at idx:' + str(i) + ' formatted')

for (l, c) in reversed(ins):
    data = data[:l] + c + data[l:]

print('')
print('')

print('======== WRITE ========')
with open(foutput, "w") as tf:
    tf.write(data)
    print(str(len(data)) + ' characters written to ' + foutput)

print('')
print('')

print('======== REMOVE MAP ========')
if os.path.isfile(finput + '.map'):
    try:
        os.remove(finput + '.map')
        print(finput + '.map' + ' deleted')
    except Exception as e:
        print(e)
else:
    print(finput + '.map' + ' does not exist')

print('')
print('')

print('Finished.')
