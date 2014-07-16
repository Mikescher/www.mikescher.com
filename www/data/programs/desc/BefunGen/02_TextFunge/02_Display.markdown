In TextFunge you can optionally define a read- and writable display area.

```textfunge
program example_01 : display[16, 16]
```

The display has a width and a height and every field has initially the value you set in the options (the standard is space).

You can access the display with the `display[x, y]` command.

```textfunge
display[0, 0] = 'X'; // Write 'X' to position (0,0)
c = display[0, 1];   // Set c to the value of (0,1)
```

There are also a few automatically defined constants for teh work with displays:

```textfunge
DISPLAY_WIDTH // The width of the display
DISPLAY_HEIGHT // The height of the display
DISPLAY_SIZE // The size (width*height) of the display
```

You can use the display to

 - display information to the user without using input commands
 - gather a big amount of data from the user before execution (he has to fill the display manually)
 - use it as a big 2-dimensional array for calculations

> **Note:**  
> Beware that there is normally no mechanism to control access overflow.  
> So you can enter to high/low x/y values and access/modify program pieces that are not part of the display.  
> This is a way of bricking your program by writing in the area of program code  
>
>**Tip:**  
> You can prevent this by enabling the compiler option *Prevent display overflow*.
> But beware that tis will result in longer display access times.