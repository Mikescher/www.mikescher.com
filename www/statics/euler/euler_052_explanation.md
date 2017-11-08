To be a permutation all six numbers have to have the same digit count. So `digitcount(x) == digitcount(x*6)`.

This for each number of digits only given for the numbers from `10^n` to `10/6 * 10^n`.  
We perform the permutation check with an modified version of the algorithm used in problem-49 *(product of all digits plus two)*.
But we generalise the code to work with every number of digits.

And because we greatly limited the amount of numbers to search and the permutation test is pretty fast this is all we need to do (except run the code).