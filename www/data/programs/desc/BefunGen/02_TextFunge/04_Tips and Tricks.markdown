Here a few tricks for programming with BefunGen:

###Horizontal size

Normally a program only grows in height, the more instructions your program has the greater is the height of the generated code.

So it is kinda bad when you have one really long line, because the width of the program is determined by the longest line.
So its good to try to avoid long lines for the sake of smaller - more compressed programs.

Here are a few common cases which compile to long single lines:

 - Deep Nesting (e.g. multiple nested `for` loops)
 - A lot of consecutive `elsif` statements
 - `Switch` statements with a lot of cases
 - Function calls with a lot of parameters
 - Very long arrays
 - Complex "one-line" statements (e.g. multiple nested method calls)

Neither of these things has any real consequence - except your program having a lot of empty space.

###Display as array

If you are in need of a really big array, or of a 2 dimensional array you can use the display for that.

The display is an easy way of having an **global** 2dimensional array, that is easily visible to the user.

###Constants

You can without hesitation use constants in your program, they are inlined on compilation and have no performance cost at all.
