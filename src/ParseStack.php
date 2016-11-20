<?php
/**
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

namespace Genesis\Lime;

class ParseStack {
	public $q;
	public $qs = array();
	/**
	 * Stack of semantic actions
	 */
	public $ss = array();

	public function __construct($qi) {
		$this->q = $qi;
	}

	public function shift($q, $semantic) {
		$this->ss[] = $semantic;
		$this->qs[] = $this->q;

		$this->q = $q;

		// echo "Shift $q -- $semantic\n";
	}

	public function top_n($n) {
		if (!$n) {
			return array();
		}

		return array_slice($this->ss, 0 - $n);
	}

	public function pop_n($n) {
		if (!$n) {
			return array();
		}

		$qq = array_splice($this->qs, 0 - $n);
		$this->q = $qq[0];

		return array_splice($this->ss, 0 - $n);
	}

	public function occupied() {
		return !empty($this->ss);
	}

	public function index($n) {
		if ($n) {
			$this->q = $this->qs[count($this->qs) - $n];
		}
	}

	public function text() {
		return $this->q . ' : ' . implode(' . ', array_reverse($this->qs));
	}
}
