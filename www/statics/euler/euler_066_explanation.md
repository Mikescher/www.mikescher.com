Okay I admit this one took me five days to complete (with two days pause in between, because of I kinda got frustrated).

I needed eight numbers that were too big for int64 so I encoded them in base-67108864 (`2^26`).
The reason for this specific number (and I had to fail first to see the problem with bigger bases) is that the biggest calculation I do is `D_0 * D_0 * D * 1`.
Which is maximally `2^26 * 2^26 * 2^10` which fits *barely* in an signed 64-bit integer.

Also I needed to first write code to multiply two numbers, both in base-67108864 and both bigger than `2^63`. Let me tell you that was no fun and long-addition is far easier to implement than long-multiplication.
Especially after first I did everything wrong and then had to redo it :/

The first running version of this program was full of debug statements (even more than normally) and had a size of 200x60. (You can look at it, it's the `Problem-066 (annotated)` file).
But after that I managed to shrink it quite a bit :D I even *(barely)* managed to fit it in the 80x25 restriction.
I have the feeling I've gotten pretty good at compacting my programs...

But back to the interesting stuff, how did I solve this one:

I can' really explain everything in detail here, so I give you a few useful links:

 - [https://en.wikipedia.org/wiki/Diophantine_equation](https://en.wikipedia.org/wiki/Diophantine_equation)
 - [https://en.wikipedia.org/wiki/Pell's_equation](https://en.wikipedia.org/wiki/Pell%27s_equation)
 - [https://en.wikipedia.org/wiki/Generalized_continued_fraction](https://en.wikipedia.org/wiki/Generalized_continued_fraction)
 - [http://www.maths.surrey.ac.uk/hosted-sites/R.Knott/Fibonacci/cfINTRO.html#section9.4](http://www.maths.surrey.ac.uk/hosted-sites/R.Knott/Fibonacci/cfINTRO.html#section9.4)

If you want to have the `(x|y)` solution for a number D:

 - First you calculate the continuous fraction of `sqrt(D)`
 - For the continuous fraction you calculate the convergents `hi / ki` (read the link about Pell's equation)
 - Now you just test if `hi` and `ki` are solutions, if not go on to the next convergent pair

In the end the algorithm is really not that complex (around 30 lines in C#) but all the numbers get so big - and you need to multiply and add the already big numbers together so you get even bigger immediate values.
So on a last note I could say ... I wished the numbers in befunge were unlimited.