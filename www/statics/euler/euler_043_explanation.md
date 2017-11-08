While trying to optimize this problem I found that you don't even need a program to solve this.
You can easily get the result by calculating it on paper.
I have documented my calculations in my [Github repo](https://github.com/Mikescher/Project-Euler_Befunge).
But I wanted an program to do this (where you could for example change the constraints), so I wrote this.

The code here was a tight fit into the Befunge-93 80x25 grid, not because of some big data structures but because of a lot of code.

Here we generate all combinations from the last digit to the first, we significantly limit the amount of possible combinations by checking the constraints for every number.  
For example we are at `???????410`, we then don't need to evaluate the first 7 digits because constraint 7 is violated (divisibility of d_789 by 17).
This way instead of evaluating `3,628,800` possibilities we only have to look at `1702`.