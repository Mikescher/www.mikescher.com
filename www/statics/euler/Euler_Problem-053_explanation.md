*That* is the kind of problem I really like. There is a lot of depth in the solution and a proper algorithm solves this in no time.

The algorithm idea here is that we use the properties of [Pascal's Triangle](https://en.wikipedia.org/wiki/Pascal%27s_triangle).
As you probably know this triangle starts at its top with a `1`. Then every cell is calculated as the sum of the two cells above it.

~~~
cell[y][x] = cell[y-1][x-1] + cell[y-1][x]
~~~

![Animated GIF of Pascals Triangle. (c) by Wikimedia Foundation](https://upload.wikimedia.org/wikipedia/commons/0/0d/PascalTriangleAnimated2.gif)

When we calculate `C(n, r)` this is nothing more than the number at row *n* and column *r*.

So what we do is build [Pascal's Triangle](https://en.wikipedia.org/wiki/Pascal%27s_triangle) up to a height of one-hundred and look at the cells with values greater than one million.
The obvious problem is that the numbers grow extremely big, and sooner or later *(probably sooner)* the numbers will overflow. So what we do is use a little trick:  
As soon as a cell is over `1 000 000` we mark her *(= put a zero in that cell)*. When we create a new cell out of its two parents we check if one of the parents has the mark *(= is zero)* and then the children gets also marked. Because if one of the parents (or both) is over one million then all of its children will also be over one million.

Another "trick" is that we don't need to remember the whole triangle, only the current and the last row are important. So we have two "arrays" each representing a row and after every cycle the two change roles. The *lastRow* becomes the *currentRow* and vice versa. In Befunge we can do this simply by placing the two arrays on top of each other and accessing them with `y = row%2` or `y = (row+1)%2`.

There is one last optimisation I have done and this one will allow us to fit our program in the 80x25 Befunge-93 size restrictions.  
The triangle is symmetric and we can only look at one half of it. But we have to be aware of the fact that now every found number counts two times (one for each side) **except** it's exactly in the middle. ALso if we want to calculate the value of the middle cell we can't take the value of the right parent (this one does not exist / was never calculated), but because of it's symmetric properties we can just take the left one two times.

~~~
for(int row = 2; row <= NMAX; row++)
	for(int col = (row/2); col > 0; col--)
	{
		if (2*col == row)
			matrix[row % 2][col] = matrix[(row + 1) % 2][col - 1] * 2;
		else
			matrix[row % 2][col] = matrix[(row + 1) % 2][col] + matrix[(row + 1) % 2][col - 1];
		
			
		if (matrix[row % 2][col] > 1000000 || matrix[(row + 1) % 2][col] == 0 || matrix[(row + 1) % 2][col - 1] == 0)
		{
			count += (2 * col == row) ? 1 : 2;
			matrix[row % 2][col] = 0;
		}
	}
~~~


> **Tip:** 
>
> Run this code with [BefunExec](https://github.com/Mikescher/BefunExec) on the 50kHz speed setting - it looks quite cool in action.