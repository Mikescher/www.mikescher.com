Here we iterate through the values of a (1..99) and do (manually) the long multiplication.  
Because we have to implement the multiplication manually we get every result from a^1 to a^99 an can easily get the digitsum for these.
Then we remember the maximum digitsum and vòila, problem solved.

A few optimizations:
 - We ignore values where `a%10 == 0`, because these result in numbers consisting mostly of zeroes, and those will never have a high digitsum
 - We also ignore values for a<45, because the numbers are just to short to be really significant.