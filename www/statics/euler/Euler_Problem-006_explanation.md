My solution here is *far* more complex than necessary, mostly because I thought the temporary numbers would get too big for int32 to handle (especially sum(1,100)^2).
Later I found out I could just calculate the sum of the squares and the square of the sum and subtract them ...

But I like my solution so I'll leave it here.
While I calculate the the second value (using the distributive property), I subtract in every step as much parts of the first value (the single elements of the addition) as I can (without going negative).

That way my temporary values never greatly exceed the final result.