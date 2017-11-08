This is a really nice problem - and I kinda like the solution.

If we think about the ordered numbers we can see that the first few start with `0`, the next with `1` and so on ...  
We can also see that there are `8!` possible numbers that start with `0` (or any other digit).  
So if `1 * 8! <= (1000000 - 0)` the result starts with `0`. Otherwise if `2 * 8! <= (1000000 - 0)`, etc.  
Then after we got our first digit (`2`) we can similar calculate the second with `1 * 7! <= (1000000 - 2 * 8!)`, `2 * 7! <= (1000000 - 2 * 8!)` ...  
The last thing we have to be aware of is that this method yields us to the "n-th digit of the remaining digits". So if we got the 6th digit for our second calculation its in fact `7`, because we already used `2`.

The program now does exactly these calculations, you can see in the top row the already used digits (they are crossed out).

All in all this program pretty fast - they could really do another version of this problem with bigger numbers.