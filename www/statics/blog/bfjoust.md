[Brainfuck Joust](http://esolangs.org/wiki/BF_Joust) is a tournament for Bots written in [brainfuck](http://esolangs.org/wiki/Brainfuck) *(or at least in a brainfuck-like language)*.

The board consist of 10 to 30 fields, one player starts left and one player right. The value of every field goes from `-127` to `128` and then wraps around, every field has a value of zero, except the two starting fields (the "flags"), they have a value of `128`.

Your goal is to zero the enemy flag for two consecutive cycles and you loose if you either leave the board or the enemy zeroes your flag first. Of course the bots are written in brainfuck, which adds a whole lot of interesting limitations due to brainfucks minimalistic (7) set of operations.

The thing that surprised me the most is the [strategically depth](http://esolangs.org/wiki/BF_Joust_strategies) of the game (despite the simple rules and language) and the fact that there are [extremely efficient and complex programs](http://codu.org/eso/bfjoust/in_egobot/) out there.

So here is my own bot *(originally made for [stackexchange](http://codegolf.stackexchange.com/questions/36645/brainfedbotsforbattling-a-brainf-tournament))*, it can't really keep up with the big ones from egojoust but I'm fairly proud of it:

```
{{CODE}}
```

A few notes to the BFJoust extensions to the brainfuck language:

`(a)*n` repeats the command `a` n-times.  
`(a{b}c)%n` equals `(a)%n b (c)%n` but allows unmatched square-brackets in `a` or `b`.

So you see it's merely more than syntactic sugar, and probably more a precompiler than anything else.  
But be aware, I personally made the experience in my js interpreter that treating is as a precompiler is not always a good idea. Because once you start expanding the code, the result can become pretty big pretty fast.

BFJoust with javascript
-------------------------------

I wrote a little [BFJoust script](https://maximum-sonata.codio.io/index.html) where you can let two bots visually fight against each other, but as I said above I did the mistake of expanding the code before running it, so this only works with programs that won't expand to an insanely large brainfuck code.

And at last a few words to the arena: In BFJoust there are 40 different settings, every board length two times. One time normal and one time with one bot inverted (`+` <-> `-`). This way you can eliminate luck and see which bot performs better.


