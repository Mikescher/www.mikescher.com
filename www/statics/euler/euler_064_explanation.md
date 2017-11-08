For this I had to re-use my old [integer-squareroot](https://en.wikipedia.org/wiki/Integer_square_root) implementation 
and I ported an [algorithm](http://www.maths.surrey.ac.uk/hosted-sites/R.Knott/Fibonacci/cfINTRO.html#section7) for calculating the continued fraction to befunge.

The rest is just iterating through all the values and trying to optimize for speed.

Here two useful snippets I made while solving this puzzle:

 - Calculating the **sum** of an zero-terminated array on the stack:   `>\# :#+_+`
 - Calculating the **count** of an zero-terminated array on the stack: `0>\#+ #1:#$_$`