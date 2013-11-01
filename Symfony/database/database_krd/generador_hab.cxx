/*
 * habitaciones.cxx
 * 
 * Copyright 2013 kelwin <kelgwiin@gmail.com>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */


#include <iostream>
using namespace std;

int main(int argc, char **argv)
{
	string cat_ac,cat[] = {"\'N\'","\'B\'","\'A\'"},tmp;
	
	for (int i = 0; i < 3; i++)
	{
		cat_ac = cat[i];
		for (int j = 0; j < 20; j++)
		{
			tmp = "(1, " + cat_ac + ") ,";
			cout <<tmp<<endl;
		}
		
		for (int j = 0; j < 20; j++)
		{
			tmp = "(2, " + cat_ac + ") ,";
			cout <<tmp<<endl;
		}
		
		
	}
	
	
	return 0;
}

