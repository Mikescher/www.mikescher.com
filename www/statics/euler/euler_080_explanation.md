A short look to [Wikipedia](https://en.wikipedia.org/wiki/Methods_of_computing_square_roots#Digit-by-digit_calculation) finds us a neat algorithm to calculate the square-root digit-by-digit.

I have optimized it a little bit with the target to use not so many variables:

~~~
IEnumerable<int> DRoot(int r)
{
	BigInteger c = r;
	BigInteger p = 0;
	int x = 0;

	for (ii = 0; ii < 100; ii++)
	{	
		for (x = 0;(x+1)*(20*p + (x+1)) <= c;x++);
		c = 100*c  - 2000*p*x - 100*x*x;
		p = p*10 + x;
	}
	
	return p;
}
~~~

The algorithm is pretty simple, but *god* do I hate long addition/multiplication in Befunge.

We need 120 base-10 digits for the numbers `p`and `c`.
In our program we use base-100 notation. This way we can fit the numbers in a single befunge-93 row 
**and** can simply multiply by 100 with a single left shift operation.