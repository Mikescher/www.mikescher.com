###Fizz Buzz

A simple implementation of the [Fizz Buzz](http://en.wikipedia.org/wiki/Fizz_buzz) game.

```textfunge
program FizzBuzz
	begin
		fizzbuzz();
		quit;
	end
	
	void fizzbuzz()
	var
		int i := 0;
	begin
		i = 1;

		while (i < 100) do
			if (i % 3 == 0 && i % 5 == 0) then
				out "FizzBuzz";
			elsif (i % 3 == 0) then
				out "Fizz";
			elsif (i % 5 == 0) then
				out "Buzz";
			else
				out i;
			end

			out "\r\n";

			i++;
		end
	end
end
```

> **Note:** *This and other examples are included in the BefunGen download*