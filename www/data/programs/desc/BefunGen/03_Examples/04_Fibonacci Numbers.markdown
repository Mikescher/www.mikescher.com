###Fibonacci numbers

Calculates the [Fibonacci sequence](http://en.wikipedia.org/wiki/Fibonacci_number)

```textfunge
program Fibbonacci
	var
		int i;
	begin
		out "Input the maximum\r\n";
		in i;

		doFiber(i);
		quit;
	end
	
	void doFiber(int max)
	var
		int last := 0;
		int curr := 1;
		int tmp;
	begin
		repeat
			if (last > 0) then
				out ",";
			end
			
			out curr;
			
			tmp = curr + last;
			last = curr;
			curr = tmp;
		until (last > max)
	end
end
```

> **Note:** *This and other examples are included in the BefunGen download*