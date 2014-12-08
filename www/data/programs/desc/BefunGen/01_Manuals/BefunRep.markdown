BefunRep is an command line tool to calculate Befunge93 number representations

![BEFUNREP_MAINWINDOW](/data/programs/desc/BefunGen/01_Manuals/BefunRep_Main.png)

To execute BefunRep you need to open the windows command line (cmd.exe).

The representations are saved in a "safe", you can give the safe-path with the parameter **safe**.
There are three safe-formats available: binary (.bin), CSV (.csv) and JSON (.json). But for most cases the binary safe is the best, especially for bigger safes.

When you first generate a safe you have to give him a number range with the parameters **lower** and **upper**

> **\> BefunRep -safe="binsafe.bin" -lower=0 -upper=1000 -reset**

The **reset** command resets the safe if the file already exists.

You can update an existing safe and search for improvements

> **\> BefunRep -safe="binsafe.bin"**

Here the existing limits in the safe are re-used. But you can also extend a safe and give him a new range.

> **\> BefunRep -safe="binsafe.bin" -lower=-100 -upper=3500**

As you can see with every iteration on the same range there is a chance to find a few improvements.
You can also specify a fixed amount of iterations with the parameter **iterations**. A negative iteration number will result in calculations until no more improvements can be found.

> **\> BefunRep -safe="binsafe.bin" -reset -lower=-100 -upper=3500 -iterations=-1**

When you calculate a new safe you will get a lot of console output, this will probably slow your program down. The parameter **quiet** (or just **q**) prevents the "Found improvement" output.
Also you can specify a statistics level from 0 to 3 with **stats**, this regulates the safe statistics you can see at the end of the program.

> **\> BefunRep -safe="binsafe.bin" -reset -lower=-100 -upper=3500 -iterations=-1 -q -stats=3**

If you already have an safe and don't want to calculate anything so you only see its statistics you can use iterations=0

> **\> BefunRep -safe="binsafe.bin" -iterations=0 -stats=3**

The binary safe format is not really human readable, to get the results in a better format use the **out** parameter. Supported formats are CSV (.csv), JSON (.json) and XML (.xml). XML and JSON are useful to redirect it to other programs and CSV to manually read them, because CSV doesn't need to escape any characters.

> **\> BefunRep -safe="binsafe.bin" -reset -lower=-100 -upper=3500 -iterations=-1 -q -out="csvoutput.csv"**

Similiar to the statistics you can also use the iterations=0 trick to generate an output of an existing safe

> **\> BefunRep -safe="binsafe.bin" -iterations=0 -out="csvoutput.csv"**

Internally BefunRep has multiple algorithms that are executed one after the other. Normally all are executed but you can also specify a single one to use with the parameter **algorithm**

> **\> BefunRep -safe="binsafe.bin" -reset -lower=-100 -upper=3500 -algorithm=3**

If you need a list of the possible arguments execute BefunRep without any arguments or with **help**

> **\> BefunRep -help**
