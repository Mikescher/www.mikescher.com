###Conway's Game of Life

A simulation of [Conway's Game of Life](http://en.wikipedia.org/wiki/Conway%27s_Game_of_Life)

```textfunge
program GameOfLife : display[40, 40]
	const
		char FIELD_UNSET := ' ';
		char FIELD_SET := 'O';
		char FIELD_PREBORN := 'o';
		char FIELD_PREDEAD := 'Q';
	begin
		Init();
		
		Run();
	end
	
	void Init()
	var
		int x, y;
	begin
		for (x = 0; x < DISPLAY_WIDTH; x++)
		do
			for (y = 0; y < DISPLAY_HEIGHT; y++)
			do
				if (display[x, y] != FIELD_UNSET) then
					display[x, y] = FIELD_SET;
				else
					display[x, y] = FIELD_UNSET;
				end
			end
		end
	end
	
	void Run() 
	var
		int i := 0;
	begin
		for(;;i++) do
			Tick();
			OUTF "Tick Nr " , i ,  "\r\n";
		end
	end
	
	void Tick()
	var
		int x, y;
		int nc;
	begin
		for (x = 0; x < DISPLAY_WIDTH; x++) do
			for (y = 0; y < DISPLAY_HEIGHT; y++) do
				nc = GetNeighborCount(x, y);
			
				if (display[x, y] == FIELD_SET) then
					if (nc < 2) then // Underpopulation
						display[x, y] = FIELD_PREDEAD;
					elsif (nc > 3) then // Overcrowding
						display[x, y] = FIELD_PREDEAD;
					end
				else
					if (nc == 3) then // It lives !
						display[x, y] = FIELD_PREBORN;
					end
				end
			end
		end
		
		for (x = 0; x < DISPLAY_WIDTH; x++) do
			for (y = 0; y < DISPLAY_HEIGHT; y++) do
				if (display[x, y] == FIELD_PREBORN) then
					display[x, y] = FIELD_SET;
				elsif (display[x, y] == FIELD_PREDEAD) then
					display[x, y] = FIELD_UNSET;
				end
			end
		end
	end
	
	int GetNeighborCount(int x, int y)
	var
		int r;
	begin
		r = 0;
		
		r += (int)(display[x - 1, y - 1] == FIELD_SET || display[x - 1, y - 1] == FIELD_PREDEAD);
		r += (int)(display[x + 0, y - 1] == FIELD_SET || display[x + 0, y - 1] == FIELD_PREDEAD);
		r += (int)(display[x + 1, y - 1] == FIELD_SET || display[x + 1, y - 1] == FIELD_PREDEAD);
		r += (int)(display[x - 1, y + 0] == FIELD_SET || display[x - 1, y + 0] == FIELD_PREDEAD);
		r += (int)(display[x + 1, y + 0] == FIELD_SET || display[x + 1, y + 0] == FIELD_PREDEAD);
		r += (int)(display[x - 1, y + 1] == FIELD_SET || display[x - 1, y + 1] == FIELD_PREDEAD);
		r += (int)(display[x + 0, y + 1] == FIELD_SET || display[x + 0, y + 1] == FIELD_PREDEAD);
		r += (int)(display[x + 1, y + 1] == FIELD_SET || display[x + 1, y + 1] == FIELD_PREDEAD);
		
		return r;
	end
end
```

> **Note:** This programs needs the options `Safe Boolean Convert` and `Prevent Display Overflow` enabled

> **Note:** *This and other examples are included in the BefunGen download*