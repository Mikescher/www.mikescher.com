TextFunge is the c-like language used for BefunGen.  
Most constructs are very similar to C and Pascal, so you won't have trouble writing anything in it.

> *Note:*  
> TexFunge programs are case-insensitive. *(but please be consistent with your naming)*

###Program structure

A TextFunge program starts with the keyword `program` and the program name and ends with `end`

```textfunge
program example_01 : display[0, 0]
	begin
		// code
	end
	
	void method()
	begin
		// code
	end
end
```

between program` and `end` you can put your methods.  The first method has no header and is called the main method.
This method is called upon the beginning and when this method has finished the program terminates.

You can specify a display by writing `: display[width, height]`, if the display is not specified its has a width and height of zero.

###Types

TextFunge knows 9 different variable types:

 - Integer: A single integer value
 - Digit: A single Base-10 digit (integer in the range from `0` to `9` )
 - Character: A single character
 - Boolean: A boolean value (`TRUE` or `FALSE`)
 - Void: Nothing, used for methods that return nothing
 - Integer Array: An fixed-length array of multiple integer
 - String: An fixed-length array of multiple character
 - Digit Array: An fixed-length array of multiple digits
 - Boolean Array: An fixed-length array of multiple booleans

```textfunge
int a1;
integer a2;
int[4] a3;

char b1;
character b2;
character[4] b3; 

bool c1;
boolean c2;
bool[4] c3; 

digit d1;
digit[4] d2; 
```
 
You can freely cast all value types into each other and all array-types with the same length (see *Casts* for more information)

###Variables

Between each method header and the `begin` keyword you can specify local variables under the `var` keyword:

```textfunge
void method()
var
	int var_1, var_2;
	int var_3     := 77;
	int[4] var_4  := {0, 1, 1, 0};
	char[4] var_5 := "FFFF";
begin
```

These variables have a local scope and can't be accessed from anywhere else.

You can also at the beginning of the program specify variables with a global scope

```textfunge
program example_02
global
	int gvar_1, gvar_2;
	int gvar3;
```

> *Note:*  
> Global variables (unlike local variables) can **not** have an initializer, they will initially have the value which you specified while compiling.

To access a variable as whole just write its name, to access an specific array index write the index in square brackets:

```textfunge
var_1[0] = var_2[4 + 1];
```

###Constants

At the same position as global variables can (global) constants be defined:

```textfunge
program example_02
const
	int VERSION := 14;
	int COL_BLUE := 0x0000FF;
	char UNDERSCORE := '_';
```

Be aware that constants are always in the compiled program inlined. 
So constants are only *syntactical sugar* and result in the same as writing the literal everywhere, where you use the constant.

> *Note:*  
> You can only define constants for value types, array constants are not *yet* supported.

###Literals

You can specify (Base-10) integer literals by simply writing the number:

```textfunge
0
9283
-9283
```

And also Base-16 (Hexadecimal) integer literals with `0x`

```textfunge
0x00
0xF0F
0x123
```

Digit literals have a `#` prefix:

```textfunge
#0
#6
#9
```

Char literals are surrounded by single ticks:

```textfunge
' '
'A'
'a'
```

Boolean literals consist of the two boolean keywords:

```textfunge
true
false
TRUE
```

String literals are surrounded by quotation marks: (Be aware that a string literal is only a shortcut notation of an char array)

```textfunge
""
"hello"
"hello \r\n second line"
```

And Array literals are the values inside of a set of curly braces:

```textfunge
{0, 1}
{'h', 'e', 'l', 'l', 'o'}
{true, false, true}
```

###Methods

Methods consist of 2 parts, the header and the body:

```textfunge
int[9] method(int a, int b, int[9] c)
var
	int var_1 := 0;
	int var_2;
begin
	// Code
	// Code
	// Code
	
	return c;
end
```

In the header you define the return type (value type, array type or `void`), 
the method name (the normal C naming restriction are valid) and the parameter list (multiple value or array types).

Then you can (optionally) define local variables.

And finally between `begin` and `end` you can write your code.

> *Note:*  
> Every path of an method must result in an `return` statement.  
> If the return type is void the compiler can automatically add an return to the end.


###Control Structures

#### If / Elsif

```textfunge
if (a) then
	// Code [a == true]
elsif (b) then
	// Code [b == true]
elsif (c) then
	// Code [c == true]
else
	// Code [else]
end
```

You can write a branch statement with the keyword `if`.  
Unlike C you have to write additional `else if`-branches with the keyword `elsif` and you have to end the whole block with `end`

#### While do

The `while` loop repeats a statement block until a condition is false

```textfunge
while (running) do
	// Code
end
```

Every loop the condition is evaluated and checked.

#### Repeat until

The `repeat until` loop repeats a statement block until a condition is true

```textfunge
while (running) do
	// Code
end
```

The difference to a `while` loop is that the condition is executed at least once.

#### For

The `for` loop is a more comfortable loop, because it has an initializer field, a condition field, and a statement field

```textfunge
//  (init ; cond  ; stmt)
for (i = 0; i < 10; i++ ) do
	// Code
end
```

Each field can also be empty, allowing for this simple, infinite loop:

```textfunge
for (;;) do
	// Code
end
// <-- unreachable (without goto)
```

#### Switch case

If you want to distinct multiple values you can use a switch statement:

```textfunge
switch(c)
begin
	case ' ':
		// Code
	end 
	case '0':
		// Code
	end
	default:
		// Else-Code
	end
end
```

> *Note:*  
> This is **not** C, there is no fall-through with empty case blocks.

> *Note:*  
> Having a lot of cases in a single switch can increase the horizontal size of your program drastically.
> Think about using other possibilities in this case

#### Goto

```textfunge
goto MLBL;
out "Nobody sees me";
MLBL:
out "end";
```

You can define labels by writing the identifier and a colon (instead of a semicolon).  
And you can write goto statements with the keyword `goto`

> *Note:*  
> This is **not** C, you have to end an goto statement with an semicolon, like every other statement too.

> *Note:*  
> Use goto's sparely, they are pretty slow and I'm not sure if they are bug-free.

###Expressions
####Mathematical operators

You can use the normal mathematical operators `+`, `-`, `*`, `/`, `%` (modulo), `(` and `)`.  
Normal precedence rules apply

```textfunge
a = ((5 + 5)*4 - 10)/-1 % 4;
```

####Boolean operators

You can use the boolean operators `&&` (AND), `||` (OR), `^` (XOR), `!` (NOT).

```textfunge
a = (10 == x) ^ true;
b = !(10 == x);
```

####Comparison

You can use the normal c-like comparison operators `==`, `!=`, `<`, `>`, `<=` and `>=`

```textfunge
while (a < 100 && a > -100) do
	a *= 2;
end 
```

###Special Statements

####Random

You can either generate a random boolean value by using `rand`, or a random integer value by using `rand[?]`.

`rand[n]` generates a random number from [0, 4^n), where 0 is included and 4^n is excluded. So you are only able to set the upper border to results of the formula 4^n.

```textfunge
if (rand) do
	a = rand[6] % 10;
end 
```

> *Note:*  
> Be aware that in the example above not all values are equally distributed (4^6 % 10 != 0), but approximately it is good, and it becomes better with bigger values for n.

####Quit

The statement `quit`, `stop` or `close` instantly terminates the program. The main method will always implicitly have an `quit` at the end.

```textfunge
if (error != 0) then
	out "FATAL ERROR";
	quit;
end
```

####Code block

You can start everywhere a new code block, it probably wont change the resulting program but has its use in structuring the source code.

```textfunge
// Code
begin
	// Code
	// Code
end
// Code
```

####De-/Increment

With `++` and `--` you can increment/decrement a variable in a shorter way than a assignment.

```textfunge
a++;
a = a + 1; // equally
```

####Assignments

With a single `=` you can assign a value to a variable.

```textfunge
a = 3;
b[3] = 0;
```

###Method calls

Method calls are pretty much like in every other language.

```textfunge
method_1(0, 6, "hello");
method_2(getA(), getB(0));
```

###Comments

You can write either full line comments with `//` or block comments with `/*` and `*/`

```textfunge
/* Comment
 * Comment
 */

// Comment

method_99( /* comment */ ); 
```

###Casts

TextFunge supports explicit and implicit casting.

The cases in which implicit casts happen are:

 - `digit` -> `int`
 - `digit[]` -> `int[]` (with same length)

You can cast all other value types into each other and array types if they have the same length.

```textfunge
var
	bool b;
	int i;
	char c;
begin
	c = (char)i;
	b  = (bool)c;
```

> *Note:*  
> When casting no information is lost, so hard casting to an digit can yield to an illegal value.  
> Also casting something from an boolean does not always result in `0` or `1` (it results in `0` / `not 0`). If you want this you can enable "explicit boolean casting" in the compiler options.


###Input/Output

####Out

With the statement `out` you can output either a value or a string:

```textfunge
out 99;
out 'a';
out "Hello World";
out var_1;
```

####OutF

`Outf` is a shortcut to writing multiple `out` statement. You can give it a comma-separated list of expressions to output

```textfunge
out 99, 'a', "Hello World", var_1;
```

####In

With the `In` Statement you can ask the user for a value, the input routine differs when you give it a integer variable or a character variable.

```
var
	int var_1;
	char var_2;
begin
	in var_1; // Asks for number
	in var_2; // Asks for character
```