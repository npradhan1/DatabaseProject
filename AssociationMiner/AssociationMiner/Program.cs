using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace AssociationMiner
{
    class Program
    {
        private static double requiredFrequency = 0.00014;

        private static ArrayEqualityComparer arrEqC = new ArrayEqualityComparer();
        private static Dictionary<int[], Double> aprioriResults = new Dictionary<int[], Double>(arrEqC);
        //private static List<int[]> dataSetLines;

        private static MySqlConnection conn;

        private static List<Order> OrderList;

        private static int numOfOrders;

        static void Main(string[] args)
        {
            if(args.Length != 3)
            {
                Console.WriteLine("AssociationMiner [database username] [database password] [Frequency]");
                return ;
            }

            requiredFrequency = Double.Parse(args[0]);
            string username = args[1];
            string password = args[2];

            //List<string> fileLines = new List<string>();	
            OrderList = new List<Order>();
            //READ LINES - IN MY CASE READ IN DATABASE ENTRIES

            string connStr = "server=localhost;user="+username+";database=lbms;port=3306;password="+password+";";
            conn = new MySqlConnection(connStr);
            try
            {
                Console.WriteLine("Connecting to MySQL...");
                conn.Open();
                // Perform database operations

                string sqlCount = "SELECT COUNT(*) FROM orders";
                MySqlCommand cmd = new MySqlCommand(sqlCount, conn);
                object result = cmd.ExecuteScalar();
                if (result != null)
                {
                    int r = Convert.ToInt32(result);
                    numOfOrders = r;

                    for (int i = 1; i <= r; i++)
                    {
                        Order orderToAdd = new Order();

                        string sql1 = "SELECT * FROM orders WHERE o_id=" + i;
                        MySqlCommand cmd1 = new MySqlCommand(sql1, conn);
                        MySqlDataReader rdr1 = cmd1.ExecuteReader();

                        while (rdr1.Read())
                        {
                            //Type test = rdr1[0].GetType();
                            orderToAdd.o_id = (uint)rdr1[0];
                            orderToAdd.m_id = (uint)rdr1[1];
                        }
                        rdr1.Close();

                        string sql2 = "SELECT * FROM transactions WHERE o_id=" + i;
                        MySqlCommand cmd2 = new MySqlCommand(sql2, conn);
                        MySqlDataReader rdr2 = cmd2.ExecuteReader();

                        while (rdr2.Read())
                        {
                            Transaction transactionToAdd = new Transaction();
                            transactionToAdd.o_id = (uint)rdr2[0];
                            transactionToAdd.b_id = (uint)rdr2[1];
                            transactionToAdd.quantity = (uint)rdr2[2];
                            orderToAdd.transactions.Add(transactionToAdd);
                        }
                        rdr2.Close();

                        OrderList.Add(orderToAdd);
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.ToString());
            }
            conn.Close();
            Console.WriteLine("Done.");

            //////////////////////////////////////////////////
		
            int maxValue = getMaxValue();

            bool continueRun = true;
            int count = 1;
            while (continueRun)
            {
                getFrequencyNumbers(count);

                trimMap(count);

                continueRun = getStatus(count);
                count++;
            }
            Console.WriteLine("Finished mining.");

            try
            {
                Console.WriteLine("Connecting to MySQL...");
                conn.Open();

                string sqlCreate1 = "CREATE TABLE IF NOT EXISTS frequentItems1 ("+
                                        "`b_id` int(10) unsigned NOT NULL, " +
                                        "`frequency` double, " +
                                        "PRIMARY KEY (`b_id`), "+
                                        "FOREIGN KEY (`b_id`) REFERENCES books(`b_id`)"+
                                        ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; "+
                                        "TRUNCATE TABLE frequentItems1;";
                MySqlCommand cmd1 = new MySqlCommand(sqlCreate1, conn);
                cmd1.ExecuteNonQuery();

                foreach (int[] key in aprioriResults.Keys)
                {
                    if (key.Length == 1) 
                    {
                        string sqlInsert1 = "INSERT INTO frequentItems1 (b_id, frequency) VALUES (" + key[0] + "," + aprioriResults[key] + ")";
                        MySqlCommand cmd1x = new MySqlCommand(sqlInsert1, conn);
                        cmd1x.ExecuteNonQuery();
                    }
                }

                string sqlCreate2 = "CREATE TABLE IF NOT EXISTS frequentItems2 (" +
                                        "`b_id1` int(10) unsigned NOT NULL, "+
                                        "`b_id2` int(10) unsigned NOT NULL, " +
                                        "`frequency` double, " +
                                        "PRIMARY KEY (`b_id1`,`b_id2`), "+
                                        "FOREIGN KEY (`b_id1`) REFERENCES books(`b_id`), "+
                                        "FOREIGN KEY (`b_id2`) REFERENCES books(`b_id`) "+
                                        ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;" +
                                        "TRUNCATE TABLE frequentItems2;";
                MySqlCommand cmd2 = new MySqlCommand(sqlCreate2, conn);
                cmd2.ExecuteNonQuery();

                foreach (int[] key in aprioriResults.Keys)
                {
                    if (key.Length == 2)
                    {
                        string sqlInsert2 = "INSERT INTO frequentItems2 (b_id1, b_id2, frequency) VALUES (" + key[0] + "," + key[1] + "," + aprioriResults[key] + ")";
                        MySqlCommand cmd2x = new MySqlCommand(sqlInsert2, conn);
                        cmd2x.ExecuteNonQuery();
                    }
                }

                string sqlCreate3 = "CREATE TABLE IF NOT EXISTS frequentItems3 (" +
                                        "`b_id1` int(10) unsigned NOT NULL, " +
                                        "`b_id2` int(10) unsigned NOT NULL, " +
                                        "`b_id3` int(10) unsigned NOT NULL, " +
                                        "`frequency` double, " +
                                        "PRIMARY KEY (`b_id1`,`b_id2`,`b_id3`), " +
                                        "FOREIGN KEY (`b_id1`) REFERENCES books(`b_id`), " +
                                        "FOREIGN KEY (`b_id2`) REFERENCES books(`b_id`), " +
                                        "FOREIGN KEY (`b_id3`) REFERENCES books(`b_id`) " +
                                        ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;" +
                                        "TRUNCATE TABLE frequentItems3;";
                MySqlCommand cmd3 = new MySqlCommand(sqlCreate3, conn);
                cmd3.ExecuteNonQuery();

                foreach (int[] key in aprioriResults.Keys)
                {
                    if (key.Length == 3)
                    {
                        string sqlInsert3 = "INSERT INTO frequentItems3 (b_id1, b_id2, b_id3, frequency) VALUES (" + key[0] + "," + key[1] + "," + key[2] + "," + aprioriResults[key] + ")";
                        MySqlCommand cmd3x = new MySqlCommand(sqlInsert3, conn);
                        cmd3x.ExecuteNonQuery();
                    }
                }

                string sqlCreate4 = "CREATE TABLE IF NOT EXISTS frequentItems4 (" +
                                        "`b_id1` int(10) unsigned NOT NULL, " +
                                        "`b_id2` int(10) unsigned NOT NULL, " +
                                        "`b_id3` int(10) unsigned NOT NULL, " +
                                        "`b_id4` int(10) unsigned NOT NULL, " +
                                        "`frequency` double, " +
                                        "PRIMARY KEY (`b_id1`,`b_id2`,`b_id3`,`b_id4`), " +
                                        "FOREIGN KEY (`b_id1`) REFERENCES books(`b_id`), " +
                                        "FOREIGN KEY (`b_id2`) REFERENCES books(`b_id`), " +
                                        "FOREIGN KEY (`b_id3`) REFERENCES books(`b_id`), " +
                                        "FOREIGN KEY (`b_id4`) REFERENCES books(`b_id`) " +
                                        ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;" +
                                        "TRUNCATE TABLE frequentItems4;";
                MySqlCommand cmd4 = new MySqlCommand(sqlCreate4, conn);
                cmd4.ExecuteNonQuery();

                foreach (int[] key in aprioriResults.Keys)
                {
                    if (key.Length == 4)
                    {
                        string sqlInsert4 = "INSERT INTO frequentItems4 (b_id1, b_id2, b_id3, b_id4, frequency) VALUES (" + key[0] + "," + key[1] + "," + key[2] + "," + key[3] + "," + aprioriResults[key] + ")";
                        MySqlCommand cmd4x = new MySqlCommand(sqlInsert4, conn);
                        cmd4x.ExecuteNonQuery();
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.ToString());
            }

            conn.Close();
            Console.WriteLine("Done.");

            return;
		
            //int count = 0;
            //for(int numFreq : numberFrequencies)
            //{
            //    System.out.println(count + " FREQ: " + numFreq);
            //    count++;
            //}
        }

        public class Order
        {
            public uint o_id;
            public uint m_id;
            public List<Transaction> transactions;

            public Order()
            {
                transactions = new List<Transaction>();
            }
        }

        public class Transaction
        {
            public uint o_id;
            public uint b_id;
            public uint quantity;
        }

        class ArrayEqualityComparer : IEqualityComparer<int[]>
        {

            public bool Equals(int[] b1, int[] b2)
            {
                if (b1.Length != b2.Length)
                    return false;

                for (int i = 0; i < b1.Length; i++)
                {
                    if (b1[i] != b2[i])
                        return false;
                }

                return true;
            }


            public int GetHashCode(int[] bx)
            {
                int hCode = 0;
                for (int i = 0; i < bx.Length; i++)
                {
                    hCode += bx[i];
                }
                return hCode.GetHashCode();
            }

        }

        public static int getMaxValue()
        {
            int maxValue = 0;
            foreach(Order order in OrderList)
            {
                if (order.transactions.Count > maxValue)
                    maxValue = order.transactions.Count;
            }
            return maxValue;
        }

        public static void trimMap(int count)
	    {
            List<int[]> removeList = new List<int[]>();
            //first convert all base counts to percentages
            List<int[]> keys = new List<int[]>(aprioriResults.Keys);
            foreach (int[] key in keys)
            {
                if(key.Length == count)
                {
                    double holder = aprioriResults[key] / numOfOrders;
                    aprioriResults[key] = holder;
                    if(holder < requiredFrequency)
                    {
                        removeList.Add(key);
                    }
                }
            }
		
            //next cut out all mapEntries that do not meet the minimum base frequency
            foreach(int[] removeItemKey in removeList)
            {
                aprioriResults.Remove(removeItemKey);
            }
	    }

        public static void getFrequencyNumbers(int count)
	    {
            foreach(Order order in OrderList)
            {
                List<int[]> combinations = getCombinations(order, count);
                foreach(int[] combo in combinations)
                {
                    if(aprioriResults.ContainsKey(combo))
                    {
                        double holder = aprioriResults[combo] + 1;
                        aprioriResults[combo] = holder;
                    }
                    else
                    {
                        aprioriResults[combo] = 1.0;
                    }
                }
            }
	    }

        public static List<int[]> getCombinations(Order order, int count)
	    {
            //GETS ALL COMBINATIONS FOR CURRENT ENTRY

		    List<uint[]> pSet = new List<uint[]>();
		    int elements = order.transactions.Count;
		    int powerElements = (int) Math.Pow(2, elements);
		
		    for (int i = 0; i < powerElements; i++)
		    {
			    String binaryCount = Convert.ToString(i,2);
                while (binaryCount.Length < elements)
                {
                    binaryCount = "0" + binaryCount;
                }
			    List<uint> tempSet = new List<uint>();

                for (int j = 0; j < elements; j++)
			    {
                    //if (binaryCount.Length <= j)
                    //    continue;

				    if(binaryCount[j]=='1')
				    {
                        //int offset = binaryCount.Length - 1;
                        tempSet.Add(order.transactions[j].b_id);
				    }
			    }
			
			    pSet.Add(tempSet.ToArray());
		    }
		
		    //trim the full powerset
            List<int[]> finalSet = new List<int[]>();
		    foreach(uint[] sublist in pSet)
		    {
			    if(sublist.Length == count)
			    {
                    int[] tempArray = new int[sublist.Length];
                    for(int j = 0; j < sublist.Length; j++)
                    {
                        tempArray[j] = (int)sublist[j];
                    }
                    finalSet.Add(tempArray);
			    }
		    }

            return finalSet;
	    }

        public static bool getStatus(int count)
	    {
            //THIS FUNCTION CHECKS TO SEE IF ANY FREQUENT SETS WHERE FOUND IN LAST RUN
		
            foreach(int[] key in aprioriResults.Keys)
            {
                if (key.Length == count)
                    return true;
            }
		
		    return false;
	    }

        //public static List<int[]> convertEntriesToIntArrays(List<string> fileLines)
        //{
        //    //SEPERATE EACH ENTRY INTO AN ARRAY OF ITEM IDS
        //    List<int[]> results = new List<int[]>();
        //    foreach(string line in fileLines)
        //    {
        //        string[] splitFileLine = line.Split(' ');
        //        int[] arrayHolder = new int[splitFileLine.Length];
        //        for (int i = 0; i < splitFileLine.Length; i++)
        //        {
        //            String trimLineSec = splitFileLine[i].Trim();
        //            int value = -1;
				    
        //            value = int.Parse(trimLineSec);

        //            arrayHolder[i] = value;
        //        }
        //        results.Add(arrayHolder);
        //    }
        //    return results;
        //}
    }
}
