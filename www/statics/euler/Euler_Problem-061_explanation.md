Pretty cool problem, I have to say.

It's one of these problem that you can easily make dynamic. In the middle-left of this program you see the number `6` surrounded with `#`.
This is the "amount of resulting numbers" parameter of our program. For this Euler-problem you need to set this to `6`.
But for debugging purposes I mostly tested it with `3`. And if you want you can try it out with bigger numbers `7` or `8`.
*(But then you need to move the code down a bit - otherwise the cache-part will intersect with the code-part)*.

With this number we first generate all the [polygon-numbers](https://en.wikipedia.org/wiki/Polygonal_number) from `3` to `SIDES_COUNT + 2` with the formula `(n-2) * (n^2 - n)/2 + n`.
Then we go recursively through all these numbers. First we test triangle[1] with square[1], then with square[2] and so on. *(The recursion is - as always - just a stack and a stack pointer)*.

A last note: This was *(until now)* probably the hardest program to fit in the befunge 80x25 size restriction.
I *barely* managed to get it (and now its exactly 80x25) and I had to use quite some trickery.