/**
 * Copyright (C) 2018-2024 E-Comprocessing Ltd.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author      E-Comprocessing Ltd.
 * @copyright   2018-2024 E-Comprocessing Ltd.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2 (GPL-2.0)
 * @package     resources/js/frontend/index
 */

import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import EcomprocessingBlocksCheckout from './EcomprocessingCheckout';
import EcomprocessingBlocksDirect from './EcomprocessingDirect';

if ( Object.keys( EcomprocessingBlocksCheckout ).length > 0 ) {
	registerPaymentMethod( EcomprocessingBlocksCheckout );
}

if ( Object.keys( EcomprocessingBlocksDirect ).length > 0 ) {
	registerPaymentMethod( EcomprocessingBlocksDirect );
}
