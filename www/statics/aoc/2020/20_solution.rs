use crate::common::AdventOfCodeDay;

use regex::Regex;
use strum::IntoEnumIterator;
use strum_macros::EnumIter;
use std::convert::TryInto;
use std::collections::HashMap;
use std::collections::HashSet;


#[derive(Debug, EnumIter, Clone, Copy, PartialEq, Eq, Hash)]
enum Compass { North, East, South, West }

impl Compass {
    pub fn transform_back(&self, tf: Transform) -> (Self, bool) {
        return match tf {

            Transform::None => match self {
                Compass::North => (Compass::North, false),
                Compass::East  => (Compass::East,  false),
                Compass::South => (Compass::South, false),
                Compass::West  => (Compass::West,  false),
            },

            Transform::RotCW090 => match self {
                Compass::North => (Compass::West,  false),
                Compass::East  => (Compass::North, false),
                Compass::South => (Compass::East,  false),
                Compass::West  => (Compass::South, false),
            },

            Transform::RotCW180 => match self {
                Compass::North => (Compass::South, false),
                Compass::East  => (Compass::West,  false),
                Compass::South => (Compass::North, false),
                Compass::West  => (Compass::East,  false),
            },

            Transform::RotCW270 => match self {
                Compass::North => (Compass::East,  false),
                Compass::East  => (Compass::South, false),
                Compass::South => (Compass::West,  false),
                Compass::West  => (Compass::North, false),
            },

            Transform::Flipped => match self {
                Compass::North => (Compass::West,  true),
                Compass::East  => (Compass::South, true),
                Compass::South => (Compass::East,  true),
                Compass::West  => (Compass::North, true),
            },

            Transform::RotCW090Flipped => match self {
                Compass::North => (Compass::North, true),
                Compass::East  => (Compass::West,  true),
                Compass::South => (Compass::South, true),
                Compass::West  => (Compass::East,  true),
            },

            Transform::RotCW180Flipped => match self {
                Compass::North => (Compass::East, true),
                Compass::East  => (Compass::North,  true),
                Compass::South => (Compass::West, true),
                Compass::West  => (Compass::South,  true),
            },

            Transform::RotCW270Flipped => match self {
                Compass::North => (Compass::South, true),
                Compass::East  => (Compass::East,  true),
                Compass::South => (Compass::North, true),
                Compass::West  => (Compass::West,  true),
            },
        };
    } 
}

#[derive(Debug, EnumIter, Clone, Copy, PartialEq, Eq, Hash)]
enum Transform {
    None, 
    RotCW090,
    RotCW180,
    RotCW270,
    Flipped, 
    RotCW090Flipped,
    RotCW180Flipped,
    RotCW270Flipped,
}

struct Tile {
    id: u32,
    bitmap: [[bool;10];10],
    sides: HashMap<(Compass, bool), (u32,u32)>,
}

pub struct Day20 {
    input: [[Tile;12];12],
}

fn new_tile_array() -> [[Tile;12];12] {
    let mut vec = Vec::<[Tile;12]>::with_capacity(12);

    for _ in 0..12 {
        let mut inner = Vec::<Tile>::with_capacity(12);
        for _ in 0..12 {
            inner.push(Tile{ id: 0, bitmap: [[false;10];10], sides: HashMap::with_capacity(4*2) });
        }
        vec.push(inner.try_into().unwrap_or_else(|_|panic!()));
    }
    return vec.try_into().unwrap_or_else(|_|panic!())
}

impl Day20 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/20_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let rex = Regex::new(r"Tile (?P<id>[0-9]+):\n(?P<bmp>([.#]{10}\n){10})").unwrap();

        let mut tiles = new_tile_array();

        let mut i = 0;
        for cap in rex.captures_iter(&input_str)
        {
            tiles[i/12][i%12].id = cap.name("id").unwrap().as_str().parse::<u32>().unwrap();
            
            let raw = cap.name("bmp").unwrap().as_str().lines().map(|l| l.chars().collect::<Vec<char>>()).collect::<Vec<Vec<char>>>();

            for y in 0..10 {
                for x in 0..10 {
                    tiles[i/12][i%12].bitmap[y][x] = raw[y][x]=='#';
                }
            }

            tiles[i/12][i%12].gen_cache();

            i+=1;
        }

        Self {
            input: tiles
        }
    }
}

impl Day20 {

    fn format_ids(tiles: &[[Tile;12];12]) -> String {
        let mut r = String::new();
        for y in 0..12 {
            for x in 0..12 {
                let pad = format!(" {}", tiles[y][x].id);
                r.push_str(&pad);
            }
            r.push('\n');
        }
        return r;
    }


    fn format_bitmaps(tiles: &[[Tile;12];12]) -> String {
        let mut r = String::with_capacity(12*12*12*12 + 1000);

        for y in 0..(12 * 11) {
            for x in 0..(12 * 11) {
            
                let gx = x / 11;
                let gy = y / 11;

                let ix = x % 11;
                let iy = y % 11;

                if ix==10 || iy == 10 { r.push(' '); continue; }

                r.push(match tiles[gy][gx].bitmap[iy][ix] {
                    true =>  '#',
                    false => '.',
                });
            }
            r.push('\n');
        }
        
        return r;
    }

    fn corner_to_transform_tl(tfs: Vec<(Compass, bool)>) -> Vec<Transform> {
        
        let rtf = tfs.iter().map(|(c,_)| *c).collect::<Vec<Compass>>();

        if rtf.contains(&Compass::West)  && rtf.contains(&Compass::North) { return vec![Transform::RotCW180, Transform::RotCW180Flipped]; }
        if rtf.contains(&Compass::North) && rtf.contains(&Compass::East)  { return vec![Transform::RotCW270, Transform::RotCW270Flipped]; }
        if rtf.contains(&Compass::East)  && rtf.contains(&Compass::South) { return vec![Transform::None,     Transform::Flipped]; }
        if rtf.contains(&Compass::South) && rtf.contains(&Compass::West)  { return vec![Transform::RotCW090, Transform::RotCW090Flipped]; }

        panic!();
    }

    fn is_valid_neigbour_horz(left: &(&Tile, Transform), right: &(&Tile, Transform)) -> bool {
        let s1 = left.0.get_side_after_transform(Compass::East, left.1);
        let s2 = right.0.get_side_after_transform(Compass::West, right.1);

        return s1.0 == s2.1;
    }

    fn is_valid_neigbour_vert(top: &(&Tile, Transform), bottom: &(&Tile, Transform)) -> bool {
        let s1 = top.0.get_side_after_transform(Compass::South, top.1);
        let s2 = bottom.0.get_side_after_transform(Compass::North, bottom.1);

        return s1.0 == s2.1;
    }

    fn is_valid_candidate(x: usize, y: usize, tile: &Tile, transform: Transform, map: &HashMap::<(usize, usize), Vec<(&Tile, Transform)>>) -> bool {
        
        if x > 0 {
            if !map.get(&(x-1, y)).unwrap().iter().any(|t| Self::is_valid_neigbour_horz(t, &(tile, transform))) {
                return false;
            }
        }

        if x < 11 {
            if !map.get(&(x+1, y)).unwrap().iter().any(|t| Self::is_valid_neigbour_horz(&(tile, transform), t)) {
                return false;
            }
        }

        if y > 0 {
            if !map.get(&(x, y-1)).unwrap().iter().any(|t| Self::is_valid_neigbour_vert(t, &(tile, transform))) {
                return false;
            }
        }

        if y < 11 {
            if !map.get(&(x, y+1)).unwrap().iter().any(|t| Self::is_valid_neigbour_vert(&(tile, transform), t)) {
                return false;
            }
        }

        return true;
    }

    fn reconstruct(tiles: &Vec<&Tile>) -> [[Tile;12];12] {

        let mut candidates = HashMap::<(usize, usize), Vec<(&Tile, Transform)>>::with_capacity(12*12);
        for y in 0..12 { 
            for x in 0..12 { 
                candidates.insert((x,y), tiles.iter().flat_map(|tile| Transform::iter().map(move |tf| (*tile, tf))).collect()); 
            } 
        }

        let corners_tl = tiles.iter()
                              .map(|t| (t, t.matching_sides(&tiles)))
                              .filter(|(_,s)| s.len()==2)
                              .map(|(t,s)| (*t, Self::corner_to_transform_tl(s)))
                              .flat_map(|(t,s)| s.iter().map(|tf| (t, *tf)).collect::<Vec<(&Tile, Transform)>>() )
                              .collect::<Vec<(&Tile, Transform)>>();

        let corner_tl = corners_tl.iter().skip(5).nth(0).unwrap();

        verboseln!("Define [0,0] := ({}, {:?}):", corner_tl.0.id, corner_tl.1);
        verboseln!("{}", corner_tl.0.transform(corner_tl.1).format_bitmap());

        candidates.insert((0, 0),  vec![*corner_tl]);

        for yy in 0..12 {
            for xx in 0..12 {
                if xx== 0 && yy == 0 { continue; }
                let other = candidates.get_mut(&(xx,yy)).unwrap();
                other.retain(|p| p.0.id != corner_tl.0.id);
            }
        }

        loop {

            let mut ok = 0;
            for y in 0..12 { 
                for x in 0..12 {
                    let cand = candidates.get(&(x,y)).unwrap();
                    if cand.len() == 1 { ok+=1; continue; }

                    let oldlen = cand.len();

                    let mut cand_clone = cand.clone();
                    cand_clone.retain(|(tile, tf)| Day20::is_valid_candidate(x, y, tile, *tf, &candidates));
                    

                    if cand_clone.len() == 0 { 
                        verboseln!("Reduced [{},{}] from {} to {} candidates", x, y, oldlen, cand_clone.len());
                        panic!("No more candidates after [is_valid_candidate]");
                    }
                    else if oldlen != cand_clone.len() { 
                        if cand_clone.len() == 1 {
                            verboseln!(" > Found tile for [{},{}] from {} candidates := ({}, {:?}):", x, y, oldlen, cand_clone[0].0.id, cand_clone[0].1);
                            verboseln!("{}", cand_clone[0].0.transform(cand_clone[0].1).format_bitmap());
                            verboseln!();
                        } else {
                            verboseln!("Reduced [{},{}] from {} to {} candidates", x, y, oldlen, cand_clone.len());
                        }

                        if cand_clone.len() == 1 {
                            for yy in 0..12 {
                                for xx in 0..12 {
                                    if x==xx && y==yy { continue; }

                                    let other = candidates.get_mut(&(xx,yy)).unwrap();
                                    
                                    let other_oldlen = other.len();
                                    other.retain(|p| p.0.id != cand_clone[0].0.id);

                                    if other_oldlen != other.len() {
                                        verboseln!("Auto-force reduced [{},{}] from {} to {} candidates (triggered by [{},{}])", xx, yy, other_oldlen, other.len(), x, y);
                                    }

                                    if other.len() == 0 { panic!("No more candidates after [retain] in [{},{}]", xx, yy); }
                                }
                            }
                        }

                        candidates.insert((x, y), cand_clone);
                    }
                    else {
                        verboseln!("No changes on [{},{}] ({} candidates)", x, y, oldlen); 
                    }
                }
            }

            if ok == 12*12 { break; }
        }

        let mut tiles = new_tile_array();
        for y in 0..12 {
            for x in 0..12 {
                tiles[y][x].id = candidates[&(x,y)][0].0.id;
                tiles[y][x].bitmap = Tile::apply_transform_10(&candidates[&(x,y)][0].0.bitmap, candidates[&(x,y)][0].1);
                tiles[y][x].gen_cache();
            }
        }
        return tiles;
    }

    pub fn find_monsters(sea: &[[bool;8*12];8*12], str_blueprint: String) -> (Vec<(usize, usize)>, Vec<(usize, usize)>) {
        let bp_width = str_blueprint.lines().nth(0).unwrap().len();
        let bp_height = str_blueprint.lines().count();
        let blueprint = str_blueprint
                                .lines()
                                .enumerate()
                                .flat_map(|(y,l)| l.chars().enumerate().filter(|(_,v)| *v=='#').map(move |(x,_)| (x,y)))
                                .collect::<Vec<_>>();

        verboseln!("Monster: {:?}", blueprint);

        let mut r = Vec::new();

        for y in 0..(8*12-bp_height) {
            for x in 0..(8*12-bp_width) {
                if blueprint.iter().all(|(dx,dy)| sea[y + *dy][x + *dx]) { r.push((x, y)); }
            }
        }

        let mk = r.iter()
                  .flat_map(|(sx,sy)| blueprint.iter().map(move |(dx,dy)| (*sx+*dx, *sy+*dy)))
                  .collect::<HashSet<_>>()
                  .iter()
                  .map(|p|*p)
                  .collect::<Vec<_>>();

        return (r, mk);
    }
}

impl Tile {
    fn format_bitmap(&self) -> String {
        let mut r = String::with_capacity(10*11);

        for y in 0..10 {
            for x in 0..10 {
                r.push(match self.bitmap[y][x] {
                    true =>  '#',
                    false => '.',
                });
            }
            r.push('\n');
        }
        return r;
    }

    fn transform(&self, tf: Transform) -> Self {
        let mut r = Self {
            id: self.id,
            bitmap: Self::apply_transform_10(&self.bitmap, tf),
            sides: HashMap::new(),
        };
        
        r.gen_cache();

        return r;
    }

    fn apply_transform_10(src: &[[bool;10];10], tf: Transform) -> [[bool;10];10] {
        let mut r = [[false;10];10];

        for src_y in 0..10 {
            for src_x in 0..10 {
                
                let dst_x: usize;
                let dst_y: usize;

                match tf {
                    Transform::None     => { dst_x = 0 + src_x; dst_y = 0 + src_y; },
                    Transform::RotCW090 => { dst_x = 9 - src_y; dst_y = 0 + src_x; },
                    Transform::RotCW180 => { dst_x = 9 - src_x; dst_y = 9 - src_y; },
                    Transform::RotCW270 => { dst_x = 0 + src_y; dst_y = 9 - src_x; },
        
                    Transform::Flipped         => { dst_x = 0 + src_y; dst_y = 0 + src_x; },
                    Transform::RotCW090Flipped => { dst_x = 9 - src_x; dst_y = 0 + src_y; },
                    Transform::RotCW180Flipped => { dst_x = 9 - src_y; dst_y = 9 - src_x; },
                    Transform::RotCW270Flipped => { dst_x = 0 + src_x; dst_y = 9 - src_y; },
                };

                r[dst_y][dst_x] = src[src_y][src_x];
            }
        }

        return r;
    }

    fn apply_transform_96(src: &[[bool;8*12];8*12], tf: Transform) -> [[bool;8*12];8*12] {
        let mut r = [[false;8*12];8*12];

        for src_y in 0..(8*12) {
            for src_x in 0..(8*12) {
                
                let dst_x: usize;
                let dst_y: usize;

                match tf {
                    Transform::None     => { dst_x = 0  + src_x; dst_y = 0  + src_y; },
                    Transform::RotCW090 => { dst_x = 95 - src_y; dst_y = 0  + src_x; },
                    Transform::RotCW180 => { dst_x = 95 - src_x; dst_y = 95 - src_y; },
                    Transform::RotCW270 => { dst_x = 0  + src_y; dst_y = 95 - src_x; },
        
                    Transform::Flipped         => { dst_x = 0  + src_y; dst_y = 0  + src_x; },
                    Transform::RotCW090Flipped => { dst_x = 95 - src_x; dst_y = 0  + src_y; },
                    Transform::RotCW180Flipped => { dst_x = 95 - src_y; dst_y = 95 - src_x; },
                    Transform::RotCW270Flipped => { dst_x = 0  + src_x; dst_y = 95 - src_y; },
                };

                r[dst_y][dst_x] = src[src_y][src_x];
            }
        }

        return r;
    }

    fn side_to_int(s: &[bool;10]) -> (u32,u32) {
        let mut u1=0;
        for i in 0..10 {
            u1 *= 2;
            if s[i] { u1 += 1; }
        }
        let mut u2=0;
        for i in 0..10 {
            u2 *= 2;
            if s[9-i] { u2 += 1; }
        }
        return (u1,u2);
    }

    fn get_side(&self, d: Compass, flipped: bool) -> (u32,u32) {
        return *self.sides.get(&(d,flipped)).unwrap();
    }

    fn get_side_after_transform(&self, d: Compass, tf: Transform) -> (u32,u32) {
        return *self.sides.get(&d.transform_back(tf)).unwrap();
    }

    fn calc_side(&self, d: Compass, flipped: bool) -> [bool;10] {
        let mut r = [false;10];

        match flipped {
            false => 
            {
                match d {
                    Compass::North => 
                    {
                        for i in 0..10 { r[i] = self.bitmap[0][i]; }
                        return r;
                    },
                    Compass::East  =>
                    {
                        for i in 0..10 { r[i] = self.bitmap[i][9]; }
                        return r;
                    },
                    Compass::South =>
                    {
                        for i in 0..10 { r[i] = self.bitmap[9][9-i]; }
                        return r;
                    },
                    Compass::West  =>
                    {
                        for i in 0..10 { r[i] = self.bitmap[9-i][0]; }
                        return r;
                    },
                }
            },
            true => 
            {
                match d {
                    Compass::North => 
                    {
                        for i in 0..10 { r[i] = self.bitmap[0][9-i]; }
                        return r;
                    },
                    Compass::East  =>
                    {
                        for i in 0..10 { r[i] = self.bitmap[9-i][9]; }
                        return r;
                    },
                    Compass::South =>
                    {
                        for i in 0..10 { r[i] = self.bitmap[9][i]; }
                        return r;
                    },
                    Compass::West  =>
                    {
                        for i in 0..10 { r[i] = self.bitmap[i][0]; }
                        return r;
                    },
                }
            },
        }
    }

    fn matching_sides(&self, tiles: &Vec<&Tile>) -> Vec<(Compass, bool)> {

        let mut r = Vec::<(Compass, bool)>::new();

        for d in Compass::iter() {
            for f in &[true, false] {
                let side = self.get_side(d, *f);
    
                let mut c = 0;
                for tile in tiles.iter().filter(|t| t.id != self.id) {
                    for d2 in Compass::iter() {
                        if side.0 == tile.get_side(d2, true).0 {
                            c+=1;
                            break;
                        }
                    }
                }
                if c > 0 {
                    r.push((d, *f))
                }
            }
        }

        return r;
    }

    fn gen_cache(&mut self) {
        for c in Compass::iter() {
            self.sides.insert((c, false), Self::side_to_int(&self.calc_side(c, false)));
            self.sides.insert((c, true),  Self::side_to_int(&self.calc_side(c, true)));
        }
    }
}

impl AdventOfCodeDay for Day20 {

    fn task_1(&self) -> String {

        verboseln!("{}", Day20::format_ids(&self.input));
        verboseln!("{}", Day20::format_bitmaps(&self.input));

        let tiles = self.input.iter().flat_map(|p| p.iter()).collect::<Vec<&Tile>>();

        if is_verbose!() {
            for t in tiles.iter().filter(|t| t.matching_sides(&tiles).len() == 2) {
                verboseln!("{}", t.format_bitmap());
            }
        }

        return tiles.iter().filter(|t| t.matching_sides(&tiles).len() == 2).map(|p| p.id as u128).product::<u128>().to_string();
    }

    fn task_2(&self) -> String  {
        let tiles = self.input.iter().flat_map(|p| p.iter()).collect::<Vec<&Tile>>();

        let bitmap_r = Day20::reconstruct(&tiles);

        verboseln!("Reconstructed:");
        verboseln!("{}", Day20::format_bitmaps(&bitmap_r));

        let mut bitmap_full: [[bool;8*12];8*12] = [[false;8*12];8*12];
        for gy in 0..12 {
            for gx in 0..12 {
                for iy in 1..9 {
                    for ix in 1..9 {
                        bitmap_full[gy*8+iy-1][gx*8+ix-1] = bitmap_r[gy][gx].bitmap[iy][ix];
                    }
                }
            }
        }

        if is_verbose!() {
            verboseln!("Raw:");
            let mut ostr = String::with_capacity(8*12*8*12);
            for y in 0..(8*12) {
                for x in 0..(8*12) {
                    ostr.push(if bitmap_full[y][x] {'#'} else {'.'})
                }
                ostr.push('\n');
            }
            verboseln!("{}", ostr);
        }

        let monster_blueprint = "".to_owned() + 
                                "                  # " + "\n" + 
                                "#    ##    ##    ###" + "\n" +
                                " #  #  #  #  #  #   ";

        let mut monster_parts = Vec::new();
        let mut monster_bitmap: [[bool;8*12];8*12] = [[false;8*12];8*12];
        for tf in Transform::iter() {

            let bitmap_tf = Tile::apply_transform_96(&bitmap_full, tf);

            let (monsters, markers) = Day20::find_monsters(&bitmap_tf, monster_blueprint.clone());
            verboseln!("Monsters in {:?}: {:?}", tf, monsters);

            if !monsters.is_empty() {
                monster_parts = markers;
                monster_bitmap = bitmap_tf;
            }
        }

        let mut roughness = 0;
        for x in 0..(8*12) {
            for y in 0..(8*12) {
                if monster_bitmap[y][x] && !monster_parts.contains(&(x,y)) { roughness += 1; }
            }
        }

        if is_verbose!() {
            verboseln!("Analyzed:");
            let mut ostr = String::with_capacity(8*12*8*12);
            for y in 0..(8*12) {
                for x in 0..(8*12) {
                    if monster_parts.contains(&(x,y)) {
                        ostr.push('O')
                    } else {
                        ostr.push(if monster_bitmap[y][x] {'#'} else {'.'})
                    }
                }
                ostr.push('\n');
            }
            verboseln!("{}", ostr);
        }

        return roughness.to_string();
    }
}