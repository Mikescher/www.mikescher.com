Nice algorithm if you see the pattern in the numerators and denominators.

~~~
denom(n+1) = denom(n) + numer(n) * frac(n)
numer(n+1) = denom(n)
~~~

and the fraction at position n is calculated by ([OEIS-A003417](https://oeis.org/A003417)):

~~~
int GetFrac(int idx)
{
	if (idx == 0) return 2;
	if ((idx-1) % 3 == 0) return 1;
	if ((idx-1) % 3 == 1) return ((idx+1)/3)*2;
	if ((idx-1) % 3 == 2) return 1;
	return 2;
}
~~~

The rest is just multiplication and long addition (we exceed the 64bit range) a hundred times ...