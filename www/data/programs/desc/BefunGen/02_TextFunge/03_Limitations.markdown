There are a few things you should consider when creating programs with Befunge:

###Number ranges

The size of the internal numbers is dependent on the interpreter, while you can safely assume that the number is at least 16bit, everything higher is not sure.
So for bigger programs you have to either work with smaller numbers or use interpreters which use bigger sizes.

> **Tip:**  
> [BefunExec](/programs/view/BefunGen) uses 64bit integer (= long values).

###Negative numbers

A real problem are negative numbers. In created programs variables are saved in the grid.
If the interpreter does not support negative grid values you will not be able to use negative numbers.

But don't worry too much - most interpreters I know support negative numbers in the grid.

###Performance

BefunGen is definitely not a tool to create fast Befunge programs, it's a tool to create big ones.  
And while it optimize your program quite a bit, a manual written program will always be faster and smaller.

So for bigger programs you will also need an fast interpreter - otherwise the execution could take a long time

> **Tip:**  
> [BefunExec](/programs/view/BefunGen) is a pretty fast multi-threaded interpreter.


###Program size

While the generated programs are strictly bound to the Befunge-93, they can become pretty big (bigger than 80x25).

So you have to either use a Befunge-93 interpreter which ignores the size limit (many interpreters do that)
or use a Befunge-98 interpreter.

> **Tip:**  
> [BefunExec](/programs/view/BefunGen), as you probably can assume, has no "real" size limit to it.
