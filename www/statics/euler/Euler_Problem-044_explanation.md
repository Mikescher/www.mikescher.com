My first attempt at this problem took over 5 hours to compute and had a complexity of O(n^3). 

The problem is that you need a square root to inverse the pentagonal formula and Befunge has no square root function.
So I needed to implement my own version of integer square roots in Befunge (see [wikipedia](https://en.wikipedia.org/wiki/Methods_of_computing_square_roots)).
The program is still not really fast but it's good that I managed to speed it up to a time where you can execute it without waiting the whole night.

Also this program is nicely compact, by the time I'm writing this my Befunge interpreter [BefunExec](https://www.mikescher.com/programs/view/BefunUtils) has gotten a display of all possible paths a program can take.
And if you look at the graph of this program, it looks pretty interesting...