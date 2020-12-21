use crate::common::AdventOfCodeDay;

use std::collections::HashMap;
pub struct Day17 {
    width: i32,
    height: i32,
    input: Vec<Vec<bool>>,
}

impl Day17 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/17_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let lines = input_str.lines().map(String::from).collect::<Vec<String>>();

        Self {
            width: lines[0].len() as i32,
            height: lines.len() as i32,

            input: lines.iter().map(|l| l.chars().map(|c| c=='#').collect()).collect(),
        }
    }
}

trait DimensionalCoord {
    fn zero() -> Self;
    
    fn componentwise_min(&self, other: Self) -> Self;
    fn componentwise_max(&self, other: Self) -> Self;

    fn inc_all(&mut self, delta: i32);
    fn iter_neighbours<F>(&self, fun: F) where F: FnMut(Self), Self: Sized;

    fn iter_all_coords_inclusive<F>(min: Self, max: Self, fun: F) where F: FnMut(Self), Self: Sized;
}

#[derive(PartialEq, Eq, std::hash::Hash, Clone, Copy)]
struct Coord3D {
    x: i32,
    y: i32,
    z: i32,
}

impl DimensionalCoord for Coord3D {
    fn zero() -> Self {
        Self {
            x: 0,
            y: 0,
            z: 0,
        }
    }

    fn componentwise_min(&self, other: Self) -> Self {
        Self {
            x: if self.x < other.x { self.x } else { other.x },
            y: if self.y < other.y { self.y } else { other.y },
            z: if self.z < other.z { self.z } else { other.z },
        }
    }

    fn componentwise_max(&self, other: Self) -> Self {
        Self {
            x: if self.x > other.x { self.x } else { other.x },
            y: if self.y > other.y { self.y } else { other.y },
            z: if self.z > other.z { self.z } else { other.z },
        }
    }

    fn inc_all(&mut self, delta: i32) {
        self.x += delta;
        self.y += delta;
        self.z += delta;
    }

    fn iter_neighbours<F>(&self, mut fun: F) where F: FnMut(Self) {
        for dx in -1..=1 {
            for dy in -1..=1 {
                for dz in -1..=1 {
                    if dx==0 && dy==0 && dz==0 { continue; }
                    fun(Coord3D::new(self.x+dx, self.y+dy, self.z+dz));
                }
            }
        }

    }

    fn iter_all_coords_inclusive<F>(min: Self, max: Self, mut fun: F) where F: FnMut(Self) {
        for x in min.x..=max.x {
            for y in min.y..=max.y {
                for z in min.z..=max.z {
                    fun(Coord3D::new(x, y, z));
                }
            }
        }
    }
}

impl Coord3D {
    fn new(x:i32, y:i32, z:i32) -> Self {
        Self {
            x,
            y,
            z,
        }
    }
}
#[derive(PartialEq, Eq, std::hash::Hash, Clone, Copy)]
struct Coord4D {
    x: i32,
    y: i32,
    z: i32,
    w: i32,
}

impl DimensionalCoord for Coord4D {
    fn zero() -> Self {
        Self {
            x: 0,
            y: 0,
            z: 0,
            w: 0,
        }
    }

    fn componentwise_min(&self, other: Self) -> Self {
        Self {
            x: if self.x < other.x { self.x } else { other.x },
            y: if self.y < other.y { self.y } else { other.y },
            z: if self.z < other.z { self.z } else { other.z },
            w: if self.w < other.w { self.w } else { other.w },
        }
    }

    fn componentwise_max(&self, other: Self) -> Self {
        Self {
            x: if self.x > other.x { self.x } else { other.x },
            y: if self.y > other.y { self.y } else { other.y },
            z: if self.z > other.z { self.z } else { other.z },
            w: if self.w > other.w { self.w } else { other.w },
        }
    }

    fn inc_all(&mut self, delta: i32) {
        self.x += delta;
        self.y += delta;
        self.z += delta;
        self.w += delta;
    }

    fn iter_neighbours<F>(&self, mut fun: F) where F: FnMut(Self) {
        for dx in -1..=1 {
            for dy in -1..=1 {
                for dz in -1..=1 {
                    for dw in -1..=1 {
                        if dx==0 && dy==0 && dz==0 && dw==0 { continue; }
                        fun(Coord4D::new(self.x+dx, self.y+dy, self.z+dz, self.w+dw));
                    }
                }
            }
        }

    }

    fn iter_all_coords_inclusive<F>(min: Self, max: Self, mut fun: F) where F: FnMut(Self) {
        for x in min.x..=max.x {
            for y in min.y..=max.y {
                for z in min.z..=max.z {
                    for w in min.w..=max.w {
                        fun(Coord4D::new(x, y, z, w));
                    }
                }
            }
        }
    }
}

impl Coord4D {
    fn new(x:i32, y:i32, z:i32, w:i32) -> Self {
        Self {
            x,
            y,
            z,
            w,
        }
    }
}

struct PocketUniverse<TCoord: DimensionalCoord + Eq + std::hash::Hash + Clone + Copy> {
    state: HashMap<TCoord, (bool, bool)>
}

impl<TCoord: DimensionalCoord + Eq + std::hash::Hash + Clone + Copy> PocketUniverse<TCoord> {
    pub fn new() -> Self {
        Self {
            state: HashMap::with_capacity(8192),
        }
    }

    fn step(&mut self) {
        let mut min_coord = TCoord::zero();
        let mut max_coord = TCoord::zero();

        for (c, (v_old, v_curr)) in self.state.iter_mut() {
            *v_old = *v_curr;

            min_coord = min_coord.componentwise_min(*c);
            max_coord = max_coord.componentwise_max(*c);
        }
        
        min_coord.inc_all(-1);
        max_coord.inc_all(1);

        TCoord::iter_all_coords_inclusive(min_coord.clone(), max_coord.clone(), |c| self.step_single(c));
    }

    fn step_single(&mut self, c: TCoord) {

        let nbc = self.get_neighbours_old(c);

        if self.get_old(c) {

            if nbc == 2 || nbc == 3 {
                // stay active
            } else {
                self.set_new(c, false);
            }

        } else {

            if nbc == 3 {
                self.set_new(c, true);
            } else {
                // remain inactive
            }

        }
    }

    fn get_old(&self, c: TCoord) -> bool {
        if let Some((v_old, _)) = self.state.get(&c) {
            return *v_old;
        }
        return false;
    }

    fn get_neighbours_old(&self, c: TCoord) -> i32 {
        let mut count = 0;

        c.iter_neighbours(|c| {
            if self.get_old(c) {
                count+=1;
            }
        });

        return count;
    }

    fn set_new(&mut self, c: TCoord, v: bool) {
        if let Some((_, v_new)) = self.state.get_mut(&c) {
            *v_new = v;
        } else {
            self.state.insert(c, (false, v));
        }
    }

    fn count_active_new(&self) -> i32 {
        return self.state.iter().filter(|(_,v)| v.1).count() as i32;
    }
}

impl AdventOfCodeDay for Day17 {

    fn task_1(&self) -> String {

        let mut pock_uni = PocketUniverse::<Coord3D>::new();

        for x in 0..self.width {
            for y in 0..self.height {
                pock_uni.state.insert(Coord3D::new(x,y,0), (false, self.input[y as usize][x as usize]));
            }
        }

        verboseln!("After 0 cycles:");
        verboseln!("{}", pock_uni.count_active_new());
        verboseln!();

        for i in 0..6 {
            pock_uni.step();
            
            verboseln!("After {} cycles:", i+1);
            verboseln!("{}", pock_uni.count_active_new());
            verboseln!();
        }

        return pock_uni.count_active_new().to_string();
    }

    fn task_2(&self) -> String  {
        let mut pock_uni = PocketUniverse::<Coord4D>::new();

        for x in 0..self.width {
            for y in 0..self.height {
                pock_uni.state.insert(Coord4D::new(x,y,0,0), (false, self.input[y as usize][x as usize]));
            }
        }

        for _ in 0..6 { pock_uni.step(); }

        return pock_uni.count_active_new().to_string();
    }
}