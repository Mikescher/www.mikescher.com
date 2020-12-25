use crate::common::AdventOfCodeDay;

use std::collections::HashMap;
use std::cmp;
use strum::IntoEnumIterator;
use strum_macros::EnumIter;

#[derive(Debug, PartialEq, Clone, EnumIter)]
enum HexDir {
    EAST,
    SOUTHEAST,
    SOUTHWEST,
    WEST,
    NORTHWEST,
    NORTHEAST,
}

#[derive(Debug)]
pub struct Day24 {
    input: Vec<Vec<HexDir>>,
}

impl Day24 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/24_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                        .lines()
                        .map(|p| String::from(p))
                        .map(|p| Self::parse_line(p))
                        .collect::<Vec<_>>();

        Self {
            input: data
        }
    }

    fn parse_line(line: String) -> Vec<HexDir> {
        let mut r = Vec::new();

        let mut skip = false;
        for u in 0..line.len() {
            if skip { skip = false; continue; }

            let chr = line.chars().nth(u+0).unwrap();
            let nxt = line.chars().nth(u+1).unwrap_or(' ');

            r.push(match (chr,nxt) {
                ('e', _)   => { skip=false; HexDir::EAST },
                ('s', 'e') => { skip=true;  HexDir::SOUTHEAST },
                ('s', 'w') => { skip=true;  HexDir::SOUTHWEST },
                ('w', _)   => { skip=false; HexDir::WEST },
                ('n', 'w') => { skip=true;  HexDir::NORTHWEST },
                ('n', 'e') => { skip=true;  HexDir::NORTHEAST },

                _ => panic!(),
            });
        }

        return r;
    }
}

#[derive(Debug, PartialEq, Copy, Clone, Hash, Eq)]
struct HexCoordOddR {
    q: i32,
    r: i32,
}

impl HexCoordOddR {
    pub fn zero() -> Self {
        return Self {
            q: 0,
            r: 0,
        }
    }

    pub fn move_by(&self, d: &HexDir) -> Self {
        return match d {
            HexDir::EAST      => Self{ q: self.q+1,                   r: self.r   },
            HexDir::SOUTHEAST => Self{ q: self.q+realmod(self.r,2),   r: self.r+1 },
            HexDir::SOUTHWEST => Self{ q: self.q+realmod(self.r,2)-1, r: self.r+1 },
            HexDir::WEST      => Self{ q: self.q-1,                   r: self.r   },
            HexDir::NORTHWEST => Self{ q: self.q+realmod(self.r,2)-1, r: self.r-1 },
            HexDir::NORTHEAST => Self{ q: self.q+realmod(self.r,2),   r: self.r-1 },
        }
    }
}

fn realmod(v: i32, m: i32) -> i32 {
    return ((v % m) + m) % m
}

#[derive(Clone)]
struct HexGrid {
    data: HashMap<HexCoordOddR, bool>,
    min_r: i32,
    min_q: i32,
    max_r: i32,
    max_q: i32,
}

impl HexGrid {
    pub fn new() -> Self {
        return Self {
            data: HashMap::new(),
            min_r: 0,
            min_q: 0,
            max_r: 1,
            max_q: 1,
        }
    }

    fn update_coords(&mut self, c: HexCoordOddR) {
        self.min_r = cmp::min(self.min_r, c.r);
        self.max_r = cmp::max(self.max_r, c.r+1);
        self.min_q = cmp::min(self.min_q, c.q);
        self.max_q = cmp::max(self.max_q, c.q+1);
    }

    fn get(&self, c: HexCoordOddR) -> bool {
        return *self.data.get(&c).unwrap_or(&false);
    }

    fn set(&mut self, c: HexCoordOddR, v: bool) {
        self.update_coords(c);
        self.data.insert(c, v);
    }

    fn flip(&mut self, c: HexCoordOddR) {
        self.update_coords(c);
        self.data.insert(c, !*self.data.get(&c).unwrap_or(&false));
    }

    fn neighbours(&self, c: HexCoordOddR) -> usize {
        return HexDir::iter().filter(|d| self.get(c.move_by(d))).count();
    }

    fn step_automata(self) -> Self {
        let mut a = Self {
            data: HashMap::with_capacity(self.data.len()),
            min_r: 0,
            min_q: 0,
            max_r: 1,
            max_q: 1,
        };

        for r in (self.min_r-2)..(self.max_r+3) {
            for q in (self.min_q-2)..(self.max_q+3) {
                let coord = HexCoordOddR{r:r, q:q};
                let old = self.get(coord);
                let nc = self.neighbours(coord);

                if old && (nc == 0 || nc > 2) {
                    a.set(coord, false);
                } else if !old && (nc == 2) {
                    a.set(coord, true);
                } else {
                    a.set(coord, old);
                }
            }
        }

        return a;
    }
}

impl AdventOfCodeDay for Day24 {

    fn task_1(&self) -> String {

        let mut grid = HexGrid::new();

        for path in &self.input {
            
            let mut coord = HexCoordOddR::zero();
            for step in path { 
                let coord2 = coord.move_by(step); 
                verboseln!("  Move [{},{}] --[{:?}]--> [{},{}]", coord.q, coord.r, step, coord2.q, coord2.r);
                coord = coord2;
            }

            let state = !grid.get(coord);

            verboseln!("Set [{},{}] -> {}", coord.q, coord.r, state);

            grid.set(coord, state);
        }

        return grid.data.iter().filter(|(_, v)| **v).count().to_string();
    }

    fn task_2(&self) -> String  {
        let mut grid = HexGrid::new();

        for path in &self.input {
            grid.flip(path.iter().fold(HexCoordOddR::zero(), |a,b|a.move_by(b)))
        }

        for _ in 0..100 {
            verboseln!("Black: {} (Size: {}..{} | {}..{})", grid.data.iter().filter(|(_, v)| **v).count(), grid.min_r, grid.max_r, grid.min_q, grid.max_q);
            grid = grid.step_automata();
        }

        return grid.data.iter().filter(|(_, v)| **v).count().to_string();
    }
}