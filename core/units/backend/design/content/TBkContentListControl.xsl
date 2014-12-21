<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkContentListControl">
        <xsl:variable name="permalink" select="permalink"/>
        <xsl:variable name="fields" select="fields"/>
        <xsl:variable name="sortLinks" select="sortLinks"/>
        
        <div class="bk-content-list-top">
            <a href="{$permalink}/add" class="button">
                <i class="fa fa-plus"/>Add
            </a>
            <div class="clear"/>
        </div>
        
        <xsl:call-template name="Filter"/>
   
        <div class="bk-content-list">
            <div class="item odd">
                <xsl:for-each select="$fields/item">
                    <xsl:variable name="field" select="."/>
                    <div class="field">
                        <div class="inner">
                            <xsl:value-of select="title"/>
                            &#160;<a href="{$sortLinks/item[name=$field/name]/asc}"><i class="fa fa-caret-up"/></a>
                            <a href="{$sortLinks/item[name=$field/name]/desc}"><i class="fa fa-caret-down"/></a>
                        </div>
                    </div>
                </xsl:for-each>
            </div>
            <xsl:for-each select="list/item">
                <div class="item">
                    <xsl:if test="position() mod 2 = 0">
                        <xsl:attribute name="class">item odd</xsl:attribute>
                    </xsl:if>
                    <xsl:variable name="item" select="."/>
                    <xsl:for-each select="$fields/item">
                        <xsl:variable name="name" select="name"/>
                        <xsl:call-template name="Field">
                            <xsl:with-param name="field" select="."/>
                            <xsl:with-param name="value" select="$item/*[name()=$name]"/>
                        </xsl:call-template>
                    </xsl:for-each>
                    <div class="field">
                        <a href="{$permalink}/edit/{id}" class="button">
                            <i class="fa fa-edit"/>
                        </a>
                    </div>
                    <div class="clear"/>
                </div>
            </xsl:for-each>
            <div class="pagination footrow">
                <xsl:for-each select="paginationLinks/item">
                    <a href="{link}" class="pagination-link">
                        <xsl:if test="title = ../../currentPage">
                            <xsl:attribute name="class">pagination-link current</xsl:attribute>
                        </xsl:if>
                        <xsl:value-of select="title"/>
                    </a>
                </xsl:for-each>
            </div>
        </div>
    </xsl:template>
    <xsl:include href="Field.xsl"/>
    <xsl:include href="Filter.xsl"/>
</xsl:stylesheet>
