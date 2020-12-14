use crate::common::AdventOfCodeDay;

use std::fmt::Display;

#[derive(Debug, PartialEq, Clone)]
enum BoardCell {
    Floor,
    Empty,
    Full,
}

#[derive(Clone)]
struct Board {
    cells: Vec<Vec<BoardCell>>,
    width: usize,
    height: usize,
}

impl Board {
    fn parse(dat: &str) -> Board {
        Board {
            height: dat.lines().count(),
            width:  dat.lines().next().unwrap().len(),
            cells:  dat.lines().map(Board::parse_line).collect()
        }
    }

    fn parse_line(dat: &str) -> Vec<BoardCell> {
        dat.chars().map(|c| match c {
            '.' => BoardCell::Floor,
            'L' => BoardCell::Empty,
            '#' => BoardCell::Full,
            _   => panic!(),
        }).collect()
    }

    fn adjac(&self, x: i32, y: i32) -> u32 {
        let mut c = 0;

        for dx in -1..=1 {
            for dy in -1..=1 {
                if dx == 0 && dy == 0 {
                    continue;
                }
                if x+dx < 0 || y+dy < 0 || x+dx >= self.width as i32 || y+dy >= self.height as i32 {
                    continue;
                }
                if self.cells[(y+dy) as usize][(x+dx) as usize] == BoardCell::Full {
                    c+=1;
                }
            }
        }

        return c;
    }

    fn adjac2(&self, x: i32, y: i32) -> u32 {
        let mut c = 0;

        for dx in -1..=1 {
            for dy in -1..=1 {
                if dx == 0 && dy == 0 {
                    continue;
                }

                if x+dx < 0 || y+dy < 0 || x+dx >= self.width as i32 || y+dy >= self.height as i32 {
                    continue;
                }
                if self.adjac_ray(x, y, dx, dy) {
                    c+=1;
                }
            }
        }

        return c;
    }

    fn adjac_ray(&self, x : i32, y: i32, dx: i32, dy: i32) -> bool {
        for i in 1.. {
            let rx = x + dx * i;
            let ry = y + dy * i;

            if rx < 0 || ry < 0 || rx >= self.width as i32 || ry >= self.height as i32 {
                return false;
            }
            
            if self.cells[ry as usize][rx as usize] == BoardCell::Full {
                return true;
            }
            if self.cells[ry as usize][rx as usize] == BoardCell::Empty {
                return false;
            }
        }

        panic!();
    }

    fn step(&self) -> Board {

        let mut nc = self.cells.clone();

        for y in 0..self.height {
            for x in 0..self.width {
                if self.cells[y][x] == BoardCell::Full {
                    if self.adjac(x as i32, y as i32) >= 4 {
                        nc[y][x] = BoardCell::Empty; // If a seat is occupied (#) and four or more seats adjacent to it are also occupied, the seat becomes empty.
                    }
                } else if self.cells[y][x] == BoardCell::Empty {
                    if self.adjac(x as i32, y as i32) == 0 {
                        nc[y][x] = BoardCell::Full; // If a seat is empty (L) and there are no occupied seats adjacent to it, the seat becomes occupied.
                    }
                }
            }
        }

        Board {
            width: self.width,
            height: self.height,

            cells: nc,
        }
    }

    fn step2(&self) -> Board {

        let mut nc = self.cells.clone();

        for y in 0..self.height {
            for x in 0..self.width {
                if self.cells[y][x] == BoardCell::Full {
                    if self.adjac2(x as i32, y as i32) >= 5 {
                        nc[y][x] = BoardCell::Empty; // it now takes five or more visible occupied seats for an occupied seat to become empty
                    }
                } else if self.cells[y][x] == BoardCell::Empty {
                    if self.adjac2(x as i32, y as i32) == 0 {
                        nc[y][x] = BoardCell::Full; // If a seat is empty (L) and there are no occupied seats adjacent to it, the seat becomes occupied.
                    }
                }
            }
        }

        Board {
            width: self.width,
            height: self.height,

            cells: nc,
        }
    }

    fn total_occupied(&self) -> u32 {
        self.cells.iter().map(|p| p.iter().filter(|p| **p == BoardCell::Full).count() as u32).sum()
    }
}

impl PartialEq for Board {
    fn eq(&self, other: &Self) -> bool {
        if self.width != other.width {
            return false;
        }
        if self.height != other.height {
            return false;
        }

        for y in 0..self.height {
            for x in 0..self.width {
                if self.cells[y][x] != other.cells[y][x] {
                    return false;
                }
            }
        }

        return true;
    }
}

impl Display for Board {
    fn fmt(&self, f: &mut std::fmt::Formatter<'_>) -> std::fmt::Result {
        let mut r = String::with_capacity(self.width * self.height + self.height + 1);
        for y in 0..self.height {
            for x in 0..self.width {
                r.push_str(match self.cells[y][x] {
                    BoardCell::Floor => ".",
                    BoardCell::Empty => "L",
                    BoardCell::Full  => "#",
                });
            }
            r.push_str("\n");
        }
        writeln!(f, "{}", r)
    }
}

pub struct Day11 {
    input: Board,
}

impl Day11 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/11_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        Self {
            input: Board::parse(&input_str)
        }
    }
}

impl AdventOfCodeDay for Day11 {

    fn task_1(&self) -> String {
        verboseln!("{}", self.input);
        verboseln!("> Initial");

        let mut board = self.input.clone();
        loop {
            let newboard = board.step();

            verboseln!("{}", newboard);
            verboseln!("> {}", newboard.total_occupied());
            verboseln!();

            if newboard == board {
                return newboard.total_occupied().to_string();
            }

            board = newboard;
        }
    }

    fn task_2(&self) -> String  {
        verboseln!("{}", self.input);
        verboseln!("> Initial");

        let mut board = self.input.clone();
        loop {
            let newboard = board.step2();

            verboseln!("{}", newboard);
            verboseln!("> {}", newboard.total_occupied());
            verboseln!();

            if newboard == board {
                return newboard.total_occupied().to_string();
            }

            board = newboard;
        }
    }
}