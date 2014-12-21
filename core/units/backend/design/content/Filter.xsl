<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="Filter">
	<div class="filter">
	    <div class="expand">
		<i class="fa fa-filter"/>
	    </div>
	    <div class="filter-table-container gray-vertical-gradient">
		<form method="get">
		<div class="filter-table">
		    <xsl:for-each select="fields/item">
			<xsl:variable name="name" select="name"/>
			
			<xsl:if test="not(type = 'passwd')
                            and not(excludeFromFilter)
                            and not(hiddenColumn)
                            and not(type='separator')
                            ">
			    <div class="doubleColWidth">
				<div class="colWidth">
				    
				    <xsl:value-of select="title"/>
				</div>
				<div class="colWidth">
				    <xsl:call-template name="FilterField">
					<xsl:with-param name="type" select="type"/>
					<xsl:with-param name="name" select="name"/>
					<xsl:with-param name="list" select="list"/>
					<xsl:with-param name="value" select="../../filtervals/item[name=$name]/value" />
				    </xsl:call-template>
				</div>
			    </div>
			</xsl:if>
		    </xsl:for-each>
		    <div  class="doubleColWidth">
			<div class="colWidth">Sort by </div>
			<div class="colWidth">
			    <select name="sort">
				<option value='id'>--</option>
				<xsl:for-each select="fields/item[not(excludeFromFilter) and not(type='separator')]">
				    <option value='{name}'><xsl:value-of select="title"/></option>
				</xsl:for-each>
			    </select>
			     <select name="sortdir">
				<option value=''>&#8593;</option>
				<option value='DESC'>&#8595;</option>
			    </select>
			</div>
		    </div>
		    <div  class="doubleColWidth">
			<div class="colWidth">Items per page</div>
			<div class="colWidth">
			    <input type="number" name="itemsperpage" value="{itemsperpage}"/>
			</div>
		    </div>
		    <div  class="doubleColWidth">
			<div class="colWidth"/>
			<div class="colWidth">
			    <input type="submit" name="FilterClick" value="Apply"/>
			</div>
		    </div>
		</div>
		</form>
	    </div>
	</div>
    </xsl:template>
    <xsl:include href="FilterField.xsl"/>
</xsl:stylesheet>
