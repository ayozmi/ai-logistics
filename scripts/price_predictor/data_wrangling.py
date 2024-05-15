import pandas as pd

def main():
    # Read each file separately
    df1 = pd.read_csv('../../data/price_predictor/raw/Sample_Product_Data_Batch_1.csv')
    df2 = pd.read_csv('../../data/price_predictor/raw/Sample_Product_Data_Batch_2.csv')
    df3 = pd.read_csv('../../data/price_predictor/raw/Sample_Product_Data_Batch_3.csv')
    df4 = pd.read_csv('../../data/price_predictor/raw/Sample_Product_Data_Batch_4.csv')

    # Concatenate dataframes
    supply_ch_df = pd.concat([df1, df2, df3, df4], ignore_index=True)

    # DW-1: Dropping rows with null values
    supply_ch_df_cleaned = supply_ch_df.dropna()

    # DW-2: Removing dollar sign and passing to numeric type
    for column in supply_ch_df_cleaned[['Revenue generated', 'Shipping costs', 'Manufacturing costs']]:
        supply_ch_df_cleaned.loc[:, column] = supply_ch_df_cleaned.loc[:, column].str.replace('[$,]', '', regex=True).astype(float)

    # DW-3 Handling consistemcy in Routes instances
    route_mapping = {
        'a': 'Route_A', 'A': 'Route_A', 'A route': 'Route_A', 'routeA': 'Route_A', 'route_A': 'Route_A',
        'b': 'Route_B', 'B': 'Route_B', 'B route': 'Route_B', 'routeB': 'Route_B', 'route_B': 'Route_B',
        'c': 'Route_C', 'C': 'Route_C', 'C route': 'Route_C', 'routeC': 'Route_C', 'route_C': 'Route_C'
    }

    # Apply the mapping to the 'Routes' column
    supply_ch_df_cleaned.loc[:, 'Routes'] = supply_ch_df_cleaned.loc[:, 'Routes'].replace(route_mapping)

if __name__ == "__main__":
    main()